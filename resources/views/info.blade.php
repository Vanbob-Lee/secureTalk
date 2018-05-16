@php
    $my_id = Auth::user()->id;
    $is_con = DB::table('contacts')->where('user_id', $my_id)->where('con_id', $user->id)->count();
    $info = json_decode($user->info);
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>SecureTalk</title>
    <link rel="stylesheet" href="http://res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
</head>

<body>
<div class="weui-cells" style="margin-top: 0px">
    <div class="weui-cell">
        <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
            <img src="{{ $user->head or '/img/head.png' }}" style="width: 50px;display: block"/>
        </div>
        <div class="weui-cell__bd">
            <p>{{ $user->name }}</p>
            <p style="font-size: 13px;color: #888888;">邮箱：{{ $user->email or '' }}</p>
        </div>
    </div>
</div>

<div class="weui-cells__title">基本信息</div>
<div class="weui-cells">
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">性别</label>
        </div>
        <div class="weui-cell__bd">
            <select id="sex_sel" class="weui-select" name="sex" disabled="disabled">
                <option value="1">男</option>
                <option value="0">女</option>
            </select>
        </div>
    </div>
    <div class="weui-cell weui-cell_select">
        <div class="weui-cell__hd">
            <select id="city_sel" class="weui-select" name="city" disabled="disabled">
                <option value="bj">北京</option>
                <option value="sh">上海</option>
                <option value="gz">广州</option>
                <option value="sz">深圳</option>
                <option value="other">其他</option>
            </select>
            <script>
                <!--select元素不能直接指定value-->
                $('#sex_sel').val('{{ $info->sex or '' }}');
                $('#city_sel').val('{{ $info->city or 'other' }}');
            </script>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="暂未填写地址" name="address" value="{{ $info->address or '' }}" disabled="disabled"/>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">手机号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="tel" name="phone" value="{{ $info->phone or '' }}" disabled="disabled">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">出生日期</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="date" value="{{ $info->birthday or '' }}" name="birthday" disabled="disabled"/>
        </div>
    </div>
</div>

<div class="weui-cells__title">个性签名</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <textarea class="weui-textarea" placeholder="这个人很懒，什么也没有留下" rows="3" name="description" disabled="disabled">{{ $info->description or '' }}</textarea>
            <div class="weui-textarea-counter"><span>{{ isset($info->description)?strlen($info->description):'0' }}</span>/100</div>
        </div>
    </div>
</div>

@if($is_con)
    <a href="javascript:act('/logic/del_contact');" class="weui-btn weui-btn_warn" style="margin-left: 10px;margin-right: 10px">从通讯录中删除</a>
@else
    <a href="javascript:act('/logic/add_contact');" class="weui-btn weui-btn_primary" style="margin-left: 10px;margin-right: 10px">保存到通讯录</a>
@endif
<input type="hidden" id="uid" name="id" value="{{ $user->id or '' }}">
<input type="hidden" id="my_id" name="id" value="{{ $my_id or '' }}">
</body>

<div class="weui-footer weui-footer_fixed-bottom">
    <p class="weui-footer__links">
        <a href="/view/index" class="weui-footer__link">返回首页</a>
    </p>
    <p class="weui-footer__text">Copyright &copy; 2018 SecureTalk</p>
</div>
</html>

<script>
    function act(url) {
        $.ajax({
            url: url,
            data: {
                uid: $('#uid').val(),
                my_id: $('#my_id').val()
            },
            type: 'post',
            success: function (msg) {
                alert(msg);
            }
        });
    }
</script>