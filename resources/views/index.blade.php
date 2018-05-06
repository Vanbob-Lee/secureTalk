<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>SecureTalk</title>
    <link rel="stylesheet" href="http://res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="/js/index.js"></script>
    <script>
        var my_id = '{{ Auth::user()->id }}';
    </script>
</head>

<body style="height: 100%;">

<div class="weui-tab" style="height: 100%;">
    <div class="weui-tab__panel" id="panel">
        <div id="div_msg" style="display: block">@include('message')</div>
        <div id="div_con" style="display:none">@include('contacts')</div>
        <div id="div_me" style="display:none">@include('mine')</div>
    </div>
    @include('tabbar')
</div>
</body>
</html>

