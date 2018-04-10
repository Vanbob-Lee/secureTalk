<div class="weui-cells" style="margin-top: 0px">
    <div class="weui-cell">
        <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
            <img src="/img/search.png" style="width: 50px;display: block"/>
        </div>
        <div class="weui-cell__bd">
            <a href="/view/search">添加联系人</a>
            <p style="font-size: 13px;color: #888888;">按用户名或邮箱搜索，找到您的朋友</p>
        </div>
    </div>
</div>

<div class="weui-grids">
    @if(isset($friends))
        @foreach($friends as $fri)
            <a href="javascript:;" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ $fri->head or '/img/head.png' }}" alt="">
                </div>
                <p class="weui-grid__label">
                    {{ $fri->name }}
                </p>
            </a>
        @endforeach

    @else
        <div class="weui-loadmore weui-loadmore_line">
            <span class="weui-loadmore__tips">暂无好友</span>
        </div>
    @endif
</div>