<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>与 {{ $con->name }} 的聊天</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/chat.js"></script>

    <script>
        var my_id = '{{ $me->id }}';
        var my_name = '{{ $me->name }}';
        var con_name = '{{ $con->name }}';
        var cid = '{{ $con->id }}';
        var had_warn = 0;
    </script>

    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/chat.css" rel="stylesheet">
</head>

<body style="zoom: 3;">

<div style="overflow: scroll;width: 100%" id="msg_div">
    <ul class="list-group" id="list">
        @if($msg)
            @foreach($msg as $m)
                <div>
                <li class="list-group-item con_li">
                    <p style="color: #1b6d85">{{ $con->name }}&emsp;{{ $m->created_at }}</p>
                    <span style="margin-left: 5px">{{ $m->content }}</span>
                </li>
                </div>
        @endforeach
    @endif
    </ul>
</div>

<div class="footer" id="footer">
    <textarea class="form-control" id="msg" style="overflow: hidden;"></textarea>
    <div class="btn_div">
        <a href="/view/index" class="btn_serial"><span class="glyphicon glyphicon-chevron-left"></span></a>
        <a href="/view/history?cid={{ $con->id }}" class="btn_serial"><span class="glyphicon glyphicon-time"></span></a>
        <a href="/view/info?id={{ $con->id }}" class="btn_serial"><span class="glyphicon glyphicon-user"></span></a>
        <a href="/view/hide?cid={{ $con->id }}" class="btn_serial"><span class="glyphicon glyphicon-picture"></span></a>
        <button class="btn-success btn" onclick="send()" id="btn" style="margin-left: 20px">发送</button>
    </div>
</div>

</body>
</html>