var interv_id;
var ws;
var points = 0;  // 我的分数
var status_ele = $('#status');

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

// 加载题目
function load_q() {
    var data = {
        code: 1,  // 尝试加入（如无法加入则自己创建）
        my_id: my_id,
        fri_id: fid
    };
}

$(document).ready(function () {
    ws = new WebSocket('ws://127.0.0.1:8686');
    var data = {
        code: 0,  // 尝试加入（如无法加入则自己创建）
        my_id: my_id,
        fri_id: fid
    };
    ws.onopen = function () {
        var str = JSON.stringify(data);
        ws.send(str);
    };
    ws.onmessage = function (e) {
        var data = JSON.parse(e.data);
        switch (data.code) {
            case 0:{  // 成功建立对局
                var tip = '[对战邀请] 好友向您发起了挑战，点击右下角按钮进入';
                send_inner(tip);
                status_ele.text('等待加入');
            } break;

            case 1:{
                status_ele.text('双方就绪');
            } break;
        }
    }
});