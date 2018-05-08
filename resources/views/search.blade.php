<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>SecureTalk</title>
    <link rel="stylesheet" href="http://res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
</head>

<body>
<script src="/js/weui.min.js"></script>
<script src="/js/zepto.min.js"></script>
<script>
    $(function(){
        var $searchBar = $('#searchBar'),
            $searchResult = $('#searchResult'),
            $searchText = $('#searchText'),
            $searchInput = $('#searchInput'),
            $searchClear = $('#searchClear'),
            $searchCancel = $('#searchCancel');

        function hideSearchResult(){
            $searchResult.hide();
            $searchInput.val('');
        }
        function cancelSearch(){
            hideSearchResult();
            $searchBar.removeClass('weui-search-bar_focusing');
            $searchText.show();
        }

        $searchText.on('click', function(){
            $searchBar.addClass('weui-search-bar_focusing');
            $searchInput.focus();
        });
        $searchInput
            .on('blur', function () {
                if(!this.value.length) cancelSearch();
            })
            .on('input', function(){
                if(this.value.length) {
                    $searchResult.show();
                } else {
                    $searchResult.hide();
                }
            })
        ;
        $searchClear.on('click', function(){
            hideSearchResult();
            $searchInput.focus();
        });
        $searchCancel.on('click', function(){
            cancelSearch();
            $searchInput.blur();
        });
    });

    function search() {
        var word = $('#searchInput').val();
        window.location.href = '/view/search?keyword=' + word;
    }
</script>

<div class="weui-search-bar" id="searchBar">
    <form class="weui-search-bar__form">
        <div class="weui-search-bar__box">
            <i class="weui-icon-search"></i>
            <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="请输入用户名或邮箱" required/>
            <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
        </div>
        <label class="weui-search-bar__label" id="searchText">
            <i class="weui-icon-search"></i>
            <span>请输入用户名或邮箱</span>
        </label>
    </form>
    <button onclick="search();" class="weui-btn weui-btn_mini weui-btn_primary" style="margin-left: 3px">搜索</button>
</div>


@if(isset($results))
    <div class="weui-grids">
    @foreach($results as $rs)
        <a href="/view/info?id={{ $rs->id }}" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ $rs->head or '/img/head.png' }}" alt="">
            </div>
            <p class="weui-grid__label">
                {{ $rs->name }}
            </p>
        </a>
    @endforeach
    </div>
@endif

<div class="weui-footer weui-footer_fixed-bottom">
    <p class="weui-footer__links">
        <a href="/view/index" class="weui-footer__link">返回首页</a>
    </p>
    <p class="weui-footer__text">Copyright &copy; 2018 SecureTalk</p>
</div>
</body>
</html>