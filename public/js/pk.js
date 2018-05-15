var interv_id;
var ws;
var has_bind = 0;  // 是否已绑定按钮点击事件
var status_ele = $('#status');

var vue = new Vue({
    el: '#main',
    data: {
        /*
        q: {
            title: '暂未加载题目',
            A: '你好', B: '', C: '', D: ''
        },
        vue.q = {title: 'T', A:'A', B: 'B', C: 'C', D: 'D'}
        */
        q: null,
        my_points: 0,  // 我的分数
        fri_points: 0
    }
});

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
                status_ele.text('正在对战');
            } break;

            case 2:{
                vue.q = data.q;
                /* 无需动态绑定，直接在<btn>写onclick吧
                if (!has_bind) {
                    $('.my_btn').click(function () {
                        send_pos(this.value);
                    });
                    has_bind = 1;
                }
                */
            }
        }
    }
});

function chk_ans(label) {

}