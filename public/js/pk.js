var interv_id;
var ws;

var vue = new Vue({
    el: '#app',
    data: {
        q: null,
        my_points: 0,  // 我的分数
        fri_points: 0,
        timer: 10
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

function ws_send(code) {
    var data = {
        code: code,
        my_id: my_id,
        fri_id: fid
    };
    ws.send(JSON.stringify(data));
}

$(document).ready(function () {
    ws = new WebSocket('ws://127.0.0.1:8686');

    /*
    var data = {
        code: 0,  // 尝试加入（如无法加入则自己创建）
        my_id: my_id,
        fri_id: fid
    };
    ws.onopen = function () {
        var str = JSON.stringify(data);
        ws.send(str);
    };
    */


    ws.onopen = function() {
        ws_send(0);  // 尝试加入（如无法加入则自己创建）
    };


    ws.onmessage = function (e) {
        var data = JSON.parse(e.data);
        switch (data.code) {
            case 0:{  // 成功建立对局
                var tip = '[对战邀请] 好友向您发起了挑战，点击右下角按钮进入';
                //send_inner(tip); 暂不发送！
                $('#status').text('等待加入');
            } break;

            case 1:{
                $('#status').text('正在对战');
            } break;

            case 2:{  // 接收题目
                vue.q = data.q;
                //tm_start();
            } break;
        }
    }
});

function tm_start() {
    vue.timer = 10;
    interv_id = setInterval(function () {
        vue.timer -= 1;
        if (vue.timer === 0) {
            clearInterval(interv_id);
            $('.my_btn').removeClass('btn-success');
            $('.my_btn').removeClass('btn-danger');
            ws_send(1);  // 加载题目
        }
    }, 1000);
}

function chk_ans(ele) {
    if (ele.value === vue.q.answer) {
        vue.my_points += 20 * (10 - vue.timer);
        $(ele).addClass('btn-success');
    } else {
        $(ele).addClass('btn-danger');
    }
}