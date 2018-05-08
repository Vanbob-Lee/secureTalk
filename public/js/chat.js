function my_msg(str, time) {
    var list_ele = $('#list');
    var div = $('<div align="right"></div>');
    var li_ele = $('<li class="list-group-item my_li"></li>');
    var name_ele = $('<p style="color: white"></p>');
    name_ele.html('<b>' + my_name + '</b>' + '&nbsp;&nbsp;&nbsp;' + time);
    var msg_ele = $('<span style="margin-right: 5px"></span>');
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
    var name_ele = $('<p style="color: #1b6d85"></p>');
    name_ele.html('<b>' + con_name + '</b>' + '&nbsp;&nbsp;&nbsp;' + time);
    var msg_ele = $('<span style="margin-right: 5px"></span>');
    msg_ele.text(str);
    li_ele.append(name_ele);
    li_ele.append(msg_ele);
    div.append(li_ele);
    list_ele.append(div);
}

function send() {
    var msg = $('#msg').val();
    send_inner(msg);
}

function showError(error)
{
    var err_msg;
    switch(error.code)
    {
        case error.PERMISSION_DENIED:
            err_msg = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            err_msg = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            err_msg = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            err_msg = "An unknown error occurred."
            break;
    }
    alert(err_msg);
}

function get_pos() {
    var geo_obj = navigator.geolocation;
    if (geo_obj) {
        geo_obj.getCurrentPosition(send_pos, showError, {
            enableHighAccuracy: true, maximumAge: 0
        });
    } else {
        alert('浏览器不支持定位');
    }
}

var loc_msg;
function get_address(ret) {
    loc_msg = ret.result.format_address;
}
// 发送位置
function send_pos(pos) {
    loc_msg = '[定位信息] ';
    var lat = pos.coords.latitude, lng = pos.coords.longitude;
    loc_msg += '纬度：' + lat + '，经度：' + lng;
    var url = 'http://api.map.baidu.com/geocoder/v2/?location='+ lat + ',' + lng + '&output=json&ak=qp6D3Bw3qFieyg5NiA4IuxYQlbi7Ge2s&callback=get_address';
    $.getScript(url);
    send_inner(loc_msg);
}

function send_inner(msg) {
    if (msg == '') {
        alert('不能发送空消息');
        return;
    }
    $('#msg').val('');
    var content = process(msg, cid);
    var data = {
        sender_id: my_id,
        recv_id: cid,
        content: content
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
        recv_id: my_id
    };
    $.ajax({
        url: '/logic/receive',
        type: 'post',
        data: data,
        success: function(ret) {
            for (var i=0;i<ret.length;i++) {
                var plain = decrypt(ret[i].content, cid);
                new_msg(plain, ret[i].created_at);
            }
        },
        error: function (err) {
            if (!had_warn) alert('发生未知错误，可能无法接收信息');
            had_warn = 1;
        }
    });
}

$(document).ready(function () {
    // 分配高度
    var h = window.screen.height;
    var fh = $('#footer').height();
    $('#msg_div').css('height', 3.5*h - fh);

    // 解密第一批未读消息
    var cips = $('.cipher');
    for (var i=0; i<cips.length; i++) {
        var plain = decrypt(cips[i].value, cid);
        $(cips[i]).next().text(plain);
    }

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