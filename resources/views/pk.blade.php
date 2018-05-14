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
        }
    </style>
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

<div id="main" style="text-align: center">
    <div class="col-xs-2"><p>@{{ my_points }}</p></div>
    <div class="col-xs-8">
        <div v-if="q">
            <p id="q_type">@{{ q.type }}</p>
            <div><h3>@{{ q.title }}</h3></div>
            {{--
            <input type="radio" value="A" class="radio">A&nbsp;<label>@{{ q.A }}</label>
            <p><input type="radio" value="B" class="radio">B&nbsp;<label>@{{ q.B }}</label></p>
            <p><input type="radio" value="C" class="radio">C&nbsp;<label>@{{ q.C }}</label></p>
            <p><input type="radio" value="D" class="radio">D&nbsp;<label>@{{ q.D }}</label></p>
            --}}
            <button value="A" class="btn my_btn">@{{ q.A }}</button><br>
            <button value="B" class="btn my_btn">@{{ q.B }}</button><br>
            <button value="C" class="btn my_btn">@{{ q.C }}</button><br>
            <button value="D" class="btn my_btn">@{{ q.D }}</button><br>
        </div>
    </div>
    <div class="col-xs-2"><p>@{{ fri_points }}</p></div>
</div>

<script src="/js/pk.js"></script>
</body>

</html>