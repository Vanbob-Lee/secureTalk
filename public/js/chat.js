function my_msg(str, time) {
    var list_ele = $('#list');
    var div = $('<div align="right"></div>');
    var li_ele = $('<li class="list-group-item my_li"></li>');
    var name_ele = $('<span style="color: #1b6d85"></span>');
    name_ele.text(my_name + ' ' + time);
    var msg_ele = $('<br><span style="margin-right: 5px"></span>');
    msg_ele.text(str);
    li_ele.append(name_ele);
    li_ele.append(msg_ele);
    div.append(li_ele);
    list_ele.append(div);
}

function new_msg(str, time) {
    var list_ele = $('#list');
    var div = $('<div></div>');
    var li_ele = $('<li class="list-group-item con_li"></li>');
    var name_ele = $('<span style="color: #1b6d85"></span>');
    name_ele.text(con_name + '\t' + time);
    var msg_ele = $('<br><span style="margin-right: 5px"></span>');
    msg_ele.text(str);
    li_ele.append(name_ele);
    li_ele.append(msg_ele);
    div.append(li_ele);
    list_ele.append(div);
}

function send() {
    var msg = $('#msg').val();
    if (msg == '') {
        alert('不能发送空消息');
        return;
    }
    $('#msg').val('');
    var data = {
        sender_id: my_id,
        recv_id: cid,
        content: msg
    };
    $.ajax({
        url: '/logic/send_msg',
        type: 'post',
        data: data,
        success: function(ret) {
            my_msg(msg, ret);
        },
        error: function (err) {
            alert('消息发送失败');
            console.log(err);
        }
    });
}

function recv() {
    var data = {
        sender_id: cid,
        recv_id: my_id,
    };
    $.ajax({
        url: '/logic/receive',
        type: 'post',
        data: data,
        success: function(ret) {
            for (var i=0;i<ret.length;i++) {
                //console.log(ret[i]);
                new_msg(ret[i].content, ret[i].created_at);
            }
        },
        error: function (err) {
            if (!had_warn) alert('发生未知错误，可能无法接收信息');
            had_warn = 1;
        }
    });
}

$(document).ready(function () {
    var h = window.screen.height;
    var fh = $('#footer').height();
    var msg_div = $('#msg_div');
    msg_div.css('height', h - fh);

    /* 悬浮按钮
    var float_div = $('.float_div');
    float_div.click(function () {
        window.location = '/view/index';
    });
    msg_div.scroll(function (e) {
        var d = msg_div.scrollTop();
        if (d > 30) float_div.css('display', 'block');
        if (d < 10) float_div.css('display', 'none');
    });
    */
    setInterval(recv, 5000);
});