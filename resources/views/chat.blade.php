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
        var my_id = '{{ $me->id }}';
        var my_name = '{{ $me->name }}';
        var con_name = '{{ $con->name }}';
        var cid = '{{ $con->id }}';
        var had_warn = 0;

        function my_msg(str, time) {
            var list_ele = $('#list');
            var div = $('<div align="right"></div>');
            var li_ele = $('<li class="list-group-item" style="text-align: right;width: 80%;margin-top: 10px;margin-right: 10px;background-color: #5cb85c;border-color: #4cae4c;"></li>');
            var name_ele = $('<span style="color: #1b6d85"></span>');
            name_ele.text(my_name + ' ' + time);
            var msg_ele = $('<br><span style="margin-right: 5px"></span>');
            msg_ele.text(str);
            li_ele.append(name_ele);
            li_ele.append(msg_ele);
            div.append(li_ele);
            list_ele.append(div);
        }

        function new_msg(str, time) {
            var list_ele = $('#list');
            var div = $('<div></div>');
            var li_ele = $('<li class="list-group-item" style="width: 80%;margin-top: 10px;margin-left: 10px"></li>');
            var name_ele = $('<span style="color: #1b6d85"></span>');
            name_ele.text(con_name + '\t' + time);
            var msg_ele = $('<br><span style="margin-right: 5px"></span>');
            msg_ele.text(str);
            li_ele.append(name_ele);
            li_ele.append(msg_ele);
            div.append(li_ele);
            list_ele.append(div);
        }

        function send() {
            var msg = $('#msg').val();
            $('#msg').val('');
            var data = {
                sender_id: my_id,
                recv_id: cid,
                content: msg
            };
            $.ajax({
                url: '/logic/send_msg',
                type: 'post',
                data: data,
                success: function(ret) {
                    my_msg(msg, ret);
                },
                error: function (err) {
                    alert('消息发送失败');
                    console.log(err);
                }
            });
        }

        function recv() {
            var data = {
                sender_id: cid,
                recv_id: my_id,
            };
            $.ajax({
                url: '/logic/receive',
                type: 'post',
                data: data,
                success: function(ret) {
                    for (var i=0;i<ret.length;i++) {
                        console.log(ret[i]);
                        new_msg(ret[i].content, ret[i].created_at);
                    }
                },
                error: function (err) {
                    if (!had_warn) alert('发生未知错误，可能无法接收信息');
                    had_warn = 1;
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
                <div>
                <li class="list-group-item" style="width: 80%;margin-top: 10px;margin-left: 10px">
                    <span style="color: #1b6d85">{{ $m->sender->name }}&emsp;{{ $m->created_at }}</span>
                    <br><span style="margin-left: 5px">{{ $m->content }}</span>
                </li>
                </div>
        @endforeach
    @endif
    </ul>
</div>

<div class="footer">
    <textarea class="form-control" id="msg" style="overflow: hidden;"></textarea>
    <button class="btn-success btn" onclick="send()">发送</button>
</div>

</body>
</html>