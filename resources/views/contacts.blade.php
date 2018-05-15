<div class="weui-cells" style="margin-top: 0px">
    <div class="weui-cell">
        <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
            <img src="/img/search.png" style="width: 50px;display: block"/>
        </div>
        <div class="weui-cell__bd">
            <a href="/view/search">查看用户详细信息</a>
            <p style="font-size: 13px;color: #888888;">按用户名或邮箱搜索用户</p>
        </div>
    </div>
</div>


@if(isset($contacts))
    <div class="weui-grids">
    @foreach($contacts as $con)
        <a href="/view/chat?cid={{ $con->id }}" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ $con->head or '/img/head.png' }}">
            </div>
            <p class="weui-grid__label">
                {{ $con->name }}
            </p>
        </a>
    @endforeach
    </div>
    <div class="weui-loadmore weui-loadmore_line weui-loadmore_dot">
        <span class="weui-loadmore__tips"></span>
    </div>
@else
    <div class="weui-loadmore weui-loadmore_line">
        <span class="weui-loadmore__tips">暂无好友</span>
    </div>
@endif