<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chat with {{ $con->name }}</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .footer { width:100%;position: absolute;left: 0; bottom: 0; }
    </style>

    <script>
        var sid = '{{ $my_id }}';
        var cid = '{{ $con->id }}';
        function my_msg(str) {

        }
        function send() {
            var msg = $('#msg').val();
            $.ajax({
                url: '/logic/send_msg',
                type: 'post',
                data: {
                    sender_id: sid,
                    recv_id: cid,
                    content: msg
                },
                success: function(ret) {
                    my_msg(str);
                },
                error: function (err) {
                    alert('消息发送失败');
                    console.log(err);
                }
            });
        }
    </script>
</head>

<body style="zoom: 3;">
<ul class="list-group" id="list">
    @if($msg)
        @foreach($msg as $m)
            <li class="list-group-item" style="text-align: left;width: 80%;margin-top: 10px;margin-left: 10px">
                <span style="color: #1b6d85">{{ $m->sender->name }}</span>
                <br><span style="font-size: 120%;margin-left: 5px">{{ $m->content }}</span>
            </li>
        @endforeach
    @endif
        <li class="list-group-item pull-right"
            style="text-align: right;width: 80%;margin-top: 10px;margin-right: 10px;background: #2ca02c">
            <span style="color: #1b6d85">me</span>
            <br><span style="font-size: 120%;margin-right: 5px">msg</span>
        </li>
</ul>

<div class="footer">
    <textarea class="form-control" id="msg" style="overflow: hidden;width: 100%;"></textarea>
    <div style="margin-top: 10px">
        <button class="btn-default btn">聊天记录</button>
        <button class="btn-success btn" onclick="send()">发送</button>
    </div>
</div>

</body>
</html>