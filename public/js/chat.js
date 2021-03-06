﻿﻿function my_msg(str, time) {
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
    $('#msg').val('');
}

function showError(error) {
    var err_msg;
    switch(error.code)
    {
        case error.PERMISSION_DENIED:
            err_msg = "User denied the request for Geolocation.";
            break;
        case error.POSITION_UNAVAILABLE:
            err_msg = "Location information is unavailable.";
            break;
        case error.TIMEOUT:
            err_msg = "The request to get user location timed out.";
            break;
        case error.UNKNOWN_ERROR:
            err_msg = "An unknown error occurred.";
            break;
    }
    alert(err_msg);
}

function get_pos() {
    if (!confirm('确认要将您的当前位置发送给好友吗？')) return;
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
    var rs = ret.result;
    loc_msg += '，地址：' + rs.formatted_address + '，描述：' + rs.sematic_description
        +'，链接'+'http://api.map.baidu.com/marker?location='+rs.location.lat+','+rs.location.lng+'&content='+rs.formatted_address+'&output=html';
    //send_inner(loc_msg);
    send_plain(loc_msg);
}
// 发送位置
function send_pos(pos) {
    loc_msg = '[定位信息] ';
    var lat = pos.coords.latitude, lng = pos.coords.longitude;
    loc_msg += '纬度：' + lat + '，经度：' + lng;
    var url = 'http://api.map.baidu.com/geocoder/v2/?location='+ lat + ',' + lng + '&output=json&ak=qp6D3Bw3qFieyg5NiA4IuxYQlbi7Ge2s&coordtype=wgs84ll&callback=get_address';
    $.getScript(url);
}

function send_inner(msg) {
    if (msg == '') {
        alert('不能发送空消息');
        return;
    }
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
            my_msg(msg, ret);  // ret: 时间戳
        },
        error: function (err) {
            alert('消息发送失败');
            console.log(err);
        }
    });
}

function send_plain(msg) {
    if (msg == '') {
        alert('不能发送空消息');
        return;
    }
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
            my_msg(msg, ret);  // ret: 时间戳
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
        var plain;
        var li_ele = $(cips[i]).parent();
        if (li_ele.hasClass('my_li')) {
            plain = decrypt_history(cips[i].value, cid, my_id);  // 解密自己的消息
        } else {
            plain = decrypt(cips[i].value, cid);  // 解密对方的
        }
        $(cips[i]).next().text(plain);
    }
    setInterval(recv, 5000);
});