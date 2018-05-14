<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
    <title>答题对战：{{ $me->name }} VS {{ $fri->name }}</title>
    <script>
        var fri_name = '{{ $fri->name }}', my_name = '{{ $me->name }}';
        var fid = '{{ $fri->id }}', my_id = '{{ $me->id }}';
    </script>
</head>
<body>
<div class="col-xs-4">
    <img src="{{ $me->head }}" width="50px" height="50px"><p>{{ $me->name }}</p>
</div>
<div class="col-xs-4">
    <p id="timer">10</p>
    <span id="status">初始化</span>
</div>
<div class="col-xs-4"><img src="{{ $fri->head }}" width="50px" height="50px"><p>{{ $fri->name }}</p></div>

<div id="main">

</div>
<script src="/js/pk.js"></script> <!--可能使用vue-->
</body>

</html>