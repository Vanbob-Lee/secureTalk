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
    <style>
        .my_btn {
            margin-top: 20px;
            width: 100%;
            white-space: normal;
        }
    </style>
</head>
<body>
<div id="app" style="text-align: center">
    <div class="col-xs-4">
        <img src="{{ $me->head }}" width="50px" height="50px"><p>{{ $me->name }}</p>
    </div>
    <div class="col-xs-4">
        <p id="timer">@{{ timer }}</p>
        <span id="status">初始化</span>
    </div>
    <div class="col-xs-4"><img src="{{ $fri->head }}" width="50px" height="50px"><p>{{ $fri->name }}</p></div>

    <div class="col-xs-2"><p>@{{ my_points }}</p></div>
    <div class="col-xs-8">
        <div v-if="q">
            <p id="q_type">@{{ q.type }}</p>
            <div><h4>@{{ q.title }}</h4></div>

            <button class="btn btn-default my_btn" onclick="chk_ans(this)" value="A">@{{ q.A }}</button><br>
            <button class="btn btn-default my_btn" onclick="chk_ans(this)" value="B">@{{ q.B }}</button><br>
            <button class="btn btn-default my_btn" onclick="chk_ans(this)" value="C">@{{ q.C }}</button><br>
            <button class="btn btn-default my_btn" onclick="chk_ans(this)" value="D">@{{ q.D }}</button><br>
        </div>
    </div>
    <div class="col-xs-2"><p>@{{ fri_points }}</p></div>
</div>

<script src="/js/pk.js"></script>
</body>

</html>