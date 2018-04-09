<div class="weui-tabbar" id="tabbar">
    <a class="weui-tabbar__item weui-bar__item_on" href="javascript:switchTo('msg');" id="a_msg">
        <img src="/img/msg.png" class="weui-tabbar__icon">
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

<script>
    function switchTo(name) {
        $('.weui-bar__item_on').each(function () {
            $(this).removeClass('weui-bar__item_on');
        });
        $('#a_' + name).addClass('weui-bar__item_on');

        /* 这样会导致<div>obj内的所有子节点全部变none!
        $('#panel div').each(function () {
            var obj = $(this);
            if (obj.attr('id') == 'div_'+ name) {
                obj.css('display', 'block');
            } else {
                obj.css('display', 'none');
            }
        });
        */

        /* 只能取到panel，不能遍历
        $('#panel').each(function (idx, ele) {
            if (idx) {
                var obj = $(ele);
                if (obj.attr('id') == 'div_'+ name) {
                    obj.css('display', 'block');
                } else {
                    obj.css('display', 'none');
                }
            }
        });
        */

        /* 测试
        $('#div_msg').css('display', 'none');
        $('#div_con').css('display', 'block');
        var chr = $('#panel div').children();  // 包含孙节点
        var chr = $('#panel').children();  // 只有直接子节点
        */
        var chr = $('#panel').children();
        for(var i=0;i<chr.length;i++) {
            var obj = $(chr[i]);
            if (obj.attr('id') == 'div_'+ name) {
                obj.css('display', 'block');
            } else {
                obj.css('display', 'none');
            }
        }
    }
</script>
