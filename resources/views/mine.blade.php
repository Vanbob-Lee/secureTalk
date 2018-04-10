@php
$me = Auth::user();
if ($me)
    $info = json_decode($me->info);
@endphp
<form id="my_info" method="post" action="/logic/edit_info">
<div class="weui-cells" style="margin-top: 0px">
    <div class="weui-cell">
        <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
            <img src="{{ $me->head or '/img/head.png' }}" style="width: 50px;display: block"/>
        </div>
        <div class="weui-cell__bd">
            <!--<p></p>-->
            @if ($me)
                <input class="weui-input" type="text" name="name" value="{{ $me->name }}"/>
                <p style="font-size: 13px;color: #888888;">登陆邮箱：{{ $me->email or '' }}</p>
            @else
                <a href="/login">点击登陆</a>
            @endif
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
            <select id="sex_sel" class="weui-select" name="sex">
                <option value="1">男</option>
                <option value="0">女</option>
            </select>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">手机号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="tel" name="phone" value="{{ $info->phone or '' }}">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">出生日期</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="date" value="{{ $info->birthday or '' }}" name="birthday"/>
        </div>
    </div>
</div>

<div class="weui-cells__title">所在地</div>
<div class="weui-cells">
    <div class="weui-cell weui-cell_select">
        <div class="weui-cell__hd">
            <select id="city_sel" class="weui-select" name="city">
                <option value="bj">北京</option>
                <option value="sh">上海</option>
                <option value="gz">广州</option>
                <option value="sz">深圳</option>
                <option value="other">其他</option>
            </select>
            <script>
                <!--select元素不能直接指定value-->
                $('#sex_sel').val('{{ $info->sex or '' }}');
                $('#city_sel').val('{{ $info->city or '' }}');
            </script>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="先选择城市，再填写详细地址" name="address" value="{{ $info->address or '' }}"/>
        </div>
    </div>
</div>

<div class="weui-cells__title">个性签名</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <textarea class="weui-textarea" placeholder="用几句话来描述自己" rows="3" name="description">{{ $info->description or '' }}</textarea>
            <div class="weui-textarea-counter"><span>{{ isset($info->description)?strlen($info->description):'0' }}</span>/100</div>
        </div>
    </div>
</div>

@if($me)
<div class="weui-flex">
    <div class="weui-flex__item"><a href="javascript:$('#my_info').submit();" class="weui-btn weui-btn_primary" style="margin-left: 10px">保存信息</a></div>
    <div class="weui-flex__item"><a href="javascript:logout();" class="weui-btn weui-btn_warn" style="margin-left: 10px;margin-right: 10px">退出登陆</a></div>
</div>
@endif

<input type="hidden" name="id" value="{{ $me->id or '' }}">
</form><!--以上所有信息当作表单处理-->

<script>

    function logout() {
        var id = $('input[name=id]').val();
        $.ajax({
            url: '/logic/logout',
            data: { id: id },
            type: 'post',
            success: function () {
                alert('您已退出登陆');
                window.location.href = '/login';
            }
        });
    }
</script>