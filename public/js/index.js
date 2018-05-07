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

var sum_unread = 0;

// 获取未读消息列表
function unread() {
    //console.log('get unread in index.js');
    $.ajax({
        url: '/logic/unread',
        type: 'post',
        data: { id: my_id },
        success: function (ret) {
            $('#list').remove();  // 删除旧列表
            $('#point').remove();
            if (ret.length) {
                $('#tip').remove();
            } else {
                if($('#tip').length === 0) {
                    var tip = $('<div class="weui-loadmore weui-loadmore_line" id="tip"><span class="weui-loadmore__tips">暂无消息</span></div>');
                    $('#cells').append(tip);
                }
                return;
            }

            var list = $('<div id="list"></div>');
            for(var i=0;i<ret.length;i++) {
                aLine(list, ret[i]);
            }
            // 直接append(html_str)也可以，不一定要加$()
            // 但加了$()能直接获取到这个jq对象
            var red_point = $('<span class="weui-badge" style="position: absolute;margin-left: -5px" id="point"></span>');
            red_point.text(sum_unread);
            $('#msg_icon').after(red_point);
            $('#cells').append(list);
        }
    });
    sum_unread = 0;
}

function aLine(list, line) {
    var cell = $('<div class="weui-cell"></div>');
    var div_left = $('<div class="weui-cell__hd" style="position: relative;margin-right: 10px;"></div>');
    var head = $('<img src="/img/head.png" style="width: 50px;display: block"/>');
    if (line.head) {
        head.attr('src', line.head);
    }
    var count = $('<span class="weui-badge" style="position: absolute;top: -.4em;right: -.4em;"></span>');
    count.text(line.unread_count);
    sum_unread += line.unread_count;
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
    var plain = decrypt(line.content, line.uid);  // 明文
    msg_p.text(plain);
    msg_a.append(msg_p);
    div_right.append(name_a);
    div_right.append(msg_a);
    cell.append(div_left);
    cell.append(div_right);
    list.append(cell);
}

setInterval(unread, 15000);