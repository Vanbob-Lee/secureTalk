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
    // 导航切换
    function switchTo(name) {
        $('.weui-bar__item_on').each(function () {
            $(this).removeClass('weui-bar__item_on');
        });
        $('#a_' + name).addClass('weui-bar__item_on');

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

    // 获取未读消息列表
    function unread() {
        $.ajax({
            url: '/logic/unread',
            type: 'post',
            data: { id: '{{ Auth::user()->id }}'},
            success: function (ret) {
                console.log(ret);
                $('#msg_list').remove();  // 删除旧列表

                if (ret.length) {
                    $('#tip').remove();
                } else {
                    if($('#tip').length == 0) {
                        var tip = $('<div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">暂无消息</span></div>');
                        $('#cells').append(tip);
                    }
                    return;
                }

                var list = $('<div class="weui-cell" id="msg_list">');
                for(var i=0;i<ret.length;i++) {
                    aLine(list, ret[i]);
                }
                $('#cells').append(list);
            }
        });
    }

    function aLine(list, line) {
        var div_left = $('<div class="weui-cell__hd" style="position: relative;margin-right: 10px;"></div>');
        var head = $('<img src="/img/head.png" style="width: 50px;display: block"/>');
        if (line.head) {
            head.attr('src', line.head);
        }
        var count = $('<span class="weui-badge" style="position: absolute;top: -.4em;right: -.4em;"></span>');
        count.text(line.unread_count);
        div_left.append(head);
        div_left.append(count);

        var div_right = $('<div class="weui-cell__bd"></div>');
        var name_a = $('<a></a>');
        name_a.attr('href', '/view/chat?cid=' + line.uid);
        var msg_a = name_a.clone();
        var name_p = $('<p style="color: black"></p>');
        name_p.text(line.name);
        name_a.append(name_p);
        var msg_p = $('<p style="font-size: 13px;color: #888888;"></p>');
        msg_p.text(line.content);
        msg_a.append(msg_p);
        div_right.append(name_a);
        div_right.append(msg_a);

        list.append(div_left);
        list.append(div_right);
    }

    setInterval(unread, 15000);
</script>
