<div class="weui-tabbar" id="tabbar">
    <a class="weui-tabbar__item weui-bar__item_on" href="javascript:switchTo('msg');" id="a_msg">
        <img src="/img/msg.png" class="weui-tabbar__icon" id="msg_icon">
        @if (count($messages))
            @php
                $sum_unread = 0;
                foreach ($messages as $msg) $sum_unread += $msg->unread_count;
            @endphp
            <span class="weui-badge" style="position: absolute;margin-left: -5px" id="point">{{ $sum_unread }}</span>
        @endif
        <p class="weui-tabbar__label">消息</p>
    </a>
    <a class="weui-tabbar__item" href="javascript:switchTo('con');" id="a_con">
        <img src="/img/contact.png" class="weui-tabbar__icon">
        <p class="weui-tabbar__label">联系人</p>
    </a>
    <a class="weui-tabbar__item" href="javascript:switchTo('me');" id="a_me">
        <img src="/img/head.png" class="weui-tabbar__icon">
        <p class="weui-tabbar__label">我</p>
    </a>
</div>
