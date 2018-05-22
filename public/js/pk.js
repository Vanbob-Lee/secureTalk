var interv_id;
var ws;
var i_chs, fri_chs;  // 自己或对方回答了当前题目
ichs = fri_chs = 0;

//环形进度条——计时
function set_cir() {
    $('.circle').each(function(index, el) {
        var num =vue.timer * 18;
        if (num<=162) {
            $(this).find('.right').css('transform', "rotate(" + num + "deg)");
        } else {
            $(this).find('.right').css('transform', "rotate(180deg)");
            $(this).find('.left').css('transform', "rotate(" + (num - 180) + "deg)");
        };
    });
}

//条形进度条——计分
function set_bar(){
    var my_bar = document.getElementById("my_bar");
    var fr_bar = document.getElementById("fr_bar");
    my_bar.style.height= vue.my_points/50 + "%";
    fr_bar.style.height= vue.fri_points/50 + "%";
}

var vue = new Vue({
    el: '#app',
    data: {
        q: null,
        my_points: 0,  // 我的分数
        fri_points: 0,
        timer: 20
    }
});  // 先让vue加载完元素

function send_inner(msg) {
    var data = {
        sender_id: my_id,
        recv_id: fid,
        content: msg
    };
    $.ajax({
        url: '/logic/send_msg',
        type: 'post',
        data: data,
        error: function (err) {
            alert('对战邀请发送失败');
            console.log(err);
        }
    });
}

// 上传自己的新分数（worker推送给对方）
function upload(point) {
    var data = {
        code: 2,
        my_id: my_id,
        fri_id: fid,
        point: point
    };
    ws.send(JSON.stringify(data));
}

function ws_send(code, points) {
    var data = {
        code: code,
        my_id: my_id,
        fri_id: fid,
        points: points
    };
    ws.send(JSON.stringify(data));
}

function terminate(msg) {
    clearInterval(interv_id);
    vue.timer = 0;
    $('.my_btn').attr('disabled', 'disabled');
    $('#status').html(msg);
    ws.close();
}

$(document).ready(function () {
    var host = window.location.hostname;  // host有端口号 hostname没有
    ws = new WebSocket('ws://'+ host +':8686');
    ws.onopen = function() {
        ws_send(0);  // 尝试加入（如无法加入则自己创建）
    };
    ws.onmessage = function (e) {
        var data = JSON.parse(e.data);
        switch (data.code) {
            case 0:{  // 成功建立对局
                var tip = '[对战邀请] 好友向您发起了挑战，点击右下角按钮进入';
                send_inner(tip);
                $('#status').text('等待加入');
            } break;

            case 1:{
                $('#status').text('正在对战');
            } break;

            case 2:{  // 接收题目
                vue.q = data.q;
                tm_start();
            } break;

            case 3:{
                fri_chs = 1;
                vue.fri_points = data.points;
                set_bar();
                if (i_chs) q_end();
            } break;

            case -1:{
                terminate('比赛结束');
            } break;

            case -2:{
                terminate('对方离开<br>比赛结束');
            } break;
        }
    }
});

function tm_start() {
    vue.timer = 20;
    set_cir();
    clearInterval(interv_id);
    interv_id = setInterval(function () {
        vue.timer -= 1;
        set_cir();
        if (vue.timer === 0) {
            set_cir();
            q_end();
        }
    }, 1000);
}

// 计时结束 或 双方都回答了，加载下一题
function q_end() {
    clearInterval(interv_id);
    var btns = $('.my_btn');
    var ans = vue.q.answer;
    $('.my_btn[value=' + ans +']').addClass('btn-success');  // 显示正确答案
    setTimeout(function () {
        btns.removeClass('btn-success');
        btns.removeClass('btn-danger');
        ws_send(1);  // 加载题目
        i_chs = fri_chs = 0;  // 还原为未答状态
        btns.removeAttr('disabled');
    }, 2000);  // 让用户看到结果
}

function chk_ans(ele) {
    i_chs = 1;
    $('.my_btn').attr('disabled', 'disabled');
    if (ele.value === vue.q.answer) {
        vue.my_points += 20 * vue.timer;
        $(ele).addClass('btn-success');
        set_bar();
    } else {
        $(ele).addClass('btn-danger');
    }
    // 只要进行了答题就一定会推送分数
    ws_send(2, vue.my_points);
    if (fri_chs) q_end();  // 自己回答时对方已回答
}