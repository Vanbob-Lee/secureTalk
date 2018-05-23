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
        body{font-family:Microsoft YaHei;
            background-image: url("/img/pk.jpg");
        }
        /*环形*/
        .circle {width: 50px; height: 50px; position: absolute; border-radius: 50%;left:0;top: 25px;right: 0;margin: auto;background: #00aacc;}
        .pie_left, .pie_right {width: 50px; height: 50px; position: absolute; top: 0;left: 0;}
        .left,.right {display: block; width:50px; height:50px;background:#0cc; border-radius: 50%;position: absolute; top: 0; left: 0;}
        .pie_right, .right { clip:rect(0,auto,auto,25px); }
        .pie_left, .left { clip:rect(0,25px,auto,0); }
        .mask { width: 37.5px; height: 37.5px; border-radius: 50%; left: 6.25px; top: 6.25px;
            background: #FFF; position: absolute; text-align: center; line-height: 37.5px; font-size: 20px; }
        /*条形*/
        .container{
            width:27px;
            padding:0px;
            border:1px solid #6C9C2C;
            height:332px;
        }
        #my_bar, #fr_bar{
            background:#45e126;
            position: absolute;
            bottom:1px;
            width:25px;
        }
    </style>
</head>
<body>
<div id="app" style="text-align: center">
    <div class="circle">
            <div class="pie_left"><div class="left"></div></div>
            <div class="pie_right"><div class="right"></div></div>
            <div class="mask"><span id="timer">@{{ timer }}</span></div>
    </div>
    <div class="col-xs-4">
        <img src="{{ $me->head }}" width="50px" height="50px"><p>{{ $me->name }}</p>
    </div>
    <div class="col-xs-4" id="top">
        <span id="status">初始化</span>
    </div>
    <div class="col-xs-4"><img src="{{ $fri->head }}" width="50px" height="50px"><p>{{ $fri->name }}</p></div>

    <div class="col-xs-2">
        <p>@{{ my_points }}</p>
        <div class="container">
            <div id="my_bar"></div>
        </div>
    </div>
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
    <div class="col-xs-2">
        <p>@{{ fri_points }}</p>
        <div class="container">
            <div id="fr_bar"></div>
        </div>
    </div>
</div>

<script src="/js/pk.js"></script>
</body>

</html>