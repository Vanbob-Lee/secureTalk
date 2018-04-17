<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chat with {{ $con->name }}</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .footer {
            display: block;
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid #eee;
        }
    </style>

    <script>
        var sid = '{{ $me->id }}';
        var my_name = '{{ $me->name }}';
        var cid = '{{ $con->id }}';

        function my_msg(str) {
            var list_ele = $('#list');
            var li_ele = $('<li class="list-group-item pull-right" style="text-align: right;width: 80%;margin-top: 10px;margin-right: 10px;background-color: #5cb85c;border-color: #4cae4c;"></li>');
            var name_ele = $('<span style="color: white"></span>');
            name_ele.text(my_name);
            var msg_ele = $('<br><span style="margin-right: 5px"></span>');
            msg_ele.text(str);
            li_ele.append(name_ele);
            li_ele.append(msg_ele);
            list_ele.append(li_ele);
        }

        function send() {
            var msg = $('#msg').val();
            $('#msg').val('');
            var data = {
                sender_id: sid,
                recv_id: cid,
                content: msg
            };
            $.ajax({
                url: '/logic/send_msg',
                type: 'post',
                data: data,
                success: function(ret) {
                    //alert(ret);
                    my_msg(msg);
                },
                error: function (err) {
                    alert('消息发送失败');
                    console.log(data);
                }
            });
        }

        function recv() {
            var data = {
                sender_id: sid,
                recv_id: cid,
            };
            $.ajax({
                url: '/logic/receive',
                type: 'post',
                data: data,
                success: function(ret) {
                    for (var i=0;i<ret.length;i++)
                        my_msg(ret[i]);
                },
                error: function (err) {
                    console.log(err);
                    alert('发生未知错误，可能无法接收信息');
                }
            });
        }

        $(document).ready(function () {
            setInterval(recv, 3000);
        });
    </script>
</head>

<body style="zoom: 3;">
<div style="overflow: scroll;height: 500px">
    <ul class="list-group" id="list">
        @if($msg)
            @foreach($msg as $m)
                <li class="list-group-item" style="text-align: left;width: 80%;margin-top: 10px;margin-left: 10px">
                    <span style="color: #1b6d85">{{ $m->sender->name }}&emsp;{{ $m->created_at }}</span>
                    <br><span style="margin-left: 5px">{{ $m->content }}</span>
                </li>
        @endforeach
    @endif
    <!--
    <li class="list-group-item pull-right"
        style="text-align: right;width: 80%;margin-top: 10px;margin-right: 10px;background: #2ca02c">
        <span style="color: #1b6d85">me</span>
        <br><span style="font-size: 120%;margin-right: 5px">msg</span>
    </li>
    -->
    </ul>
</div>

<div class="footer">
    <textarea class="form-control" id="msg" style="overflow: hidden;"></textarea>
    <button class="btn-success btn" onclick="send()">发送</button>
</div>

</body>
</html>