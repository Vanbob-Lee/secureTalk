<!DOCTYPE html>
<html lang="en" style="height: 100%;">
@include('html_head')

<body style="height: 100%;">
<!-- 使用 -->

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