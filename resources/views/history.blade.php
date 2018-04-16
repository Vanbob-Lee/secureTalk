<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chat with {{ $con->name }}</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<ul class="list-group">
    @if($msg)
        @foreach($msg as $m)
            <li class="list-group-item"
                style="text-align: {{ ($m->sender_id == $me->id)?'right':'left' }};
                        background: {{ ($m->sender_id == $me->id)?:'#2ca02c' }};
                        width: 80%;"
            >
                <p style="color: #1b6d85">{{ $m->sender_id }}</p>
                <p>{{ $m->content }}</p>
            </li>
        @endforeach
    @endif
</ul>
</body>
</html>