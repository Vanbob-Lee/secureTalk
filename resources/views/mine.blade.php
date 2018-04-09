@php($me = Auth::user())
<div class="weui-cells" style="margin-top: 0px">
    <div class="weui-cell">
        <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
            <img src="{{ $me->head or '/img/head.png' }}" style="width: 50px;display: block"/>
        </div>
        <div class="weui-cell__bd">
            <!--<p></p>-->
            <input class="weui-input" type="text" value="{{ $me->nick_name or '未登录' }}"/>
            <p style="font-size: 13px;color: #888888;">账号：{{ $me->account or '' }}</p>
        </div>
    </div>
</div>

<div class="weui-cells__title">性别</div>
<div class="weui-cells weui-cells_radio">
    <label class="weui-cell weui-check__label" for="x11">
        <div class="weui-cell__bd">
            <p>男</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" class="weui-check" name="radio1" id="x11">
            <span class="weui-icon-checked"></span>
        </div>
    </label>
    <label class="weui-cell weui-check__label" for="x12">
        <div class="weui-cell__bd">
            <p>女</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" name="radio1" class="weui-check" id="x12" checked="checked">
            <span class="weui-icon-checked"></span>
        </div>
    </label>
</div>

<div class="weui-cells__title">所在地</div>
<div class="weui-cells">

    <div class="weui-cell weui-cell_select weui-cell_select-before">
        <div class="weui-cell__hd">
            <select class="weui-select" name="select2">
                <option value="bj">北京</option>
                <option value="sh">上海</option>
                <option value="gz">广州</option>
                <option value="sz">深圳</option>
                <option value="other">其他</option>
            </select>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="详细地址"/>
        </div>
    </div>
</div>

<div class="weui-cells__title">其他信息</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">邮箱</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="email"/>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">手机号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="tel">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">出生日期</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="date" value=""/>
        </div>
    </div>
</div>

<div class="weui-cells__title">个性签名</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <textarea class="weui-textarea" placeholder="用几句话来描述自己" rows="3">{{ $me->description or '' }}</textarea>
            <div class="weui-textarea-counter"><span>{{ isset($me->description)?strlen($me->description):'0' }}</span>/100</div>
        </div>
    </div>
</div>