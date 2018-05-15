<?php
use Workerman\Worker;
require_once './Workerman/Autoloader.php';

$str = file_get_contents('db_info.json');
$info = json_decode($str, 1);
extract($info);
$con = new mysqli($host, $username, $psw, $dbname);
$sql = 'select max(id) max_id from questions';
// 打开worker后数据库新增的题目不会被抽到
$max_id = $con->query($sql)->fetch_assoc()['max_id'];

$worker = new Worker('websocket://0.0.0.0:8686');
$pk_list = [];  // element = 'req_con_id'=>['req_id', 'acc_id', 'acc_con_id', 'status', 'qids']
$worker->onMessage = function($con, $str) {
    $data = json_decode($str);
    //global $pk_list; var_dump($pk_list);
    process($con, $data);
};

$worker->onClose = function($con) {
    global $pk, $worker;
    $ret = ['code' => -1];  // 比赛结束信号
    $str = json_encode($ret);

    if ($pk[$con->id]) {  // 发起方断开
        $acc_con = $pk[$con->id]['acc_con_id'];
        $acc_con->send($str);  // 通知接受方
        unset($pk[$con->id]);

    } else {
        $con_id = find_con($con->id);
        $worker->connections[$con_id]->send($str);
        unset($pk[$con_id]);
    }
};

// 寻找 自己作为被邀请者的对局
function find_con($uid) {
    global $pk_list;
    foreach ($pk_list as $req_con_id => $pk) {
        if ($pk['acc_id'] == $uid)
            return $req_con_id;
    }
    return 0;
}

// 接受好友的挑战
function accept($con, $con_id) {
    global $pk_list;
    $pk_list[$con_id]['acc_con_id'] = $con->id;
    /*
    $pk_list[$con_id]['status'] = 1;
    echo $pk_list[$con_id]['status'];
    */
    $ret = [ 'code' => 1 ];
    $ret = json_encode($ret);
    global $worker;
    $worker->connections[$con_id]->send($ret);  // 通知发起者
    $con->send($ret);
    send_q($con_id);
}

// 自己发起挑战
function req_pk($con, $data) {
    global $pk_list;
    $pk_list[$con->id] = [
        'req_id' => $data->my_id,
        'acc_id' => $data->fri_id,
        //'status' => 0
        'qids' => []
    ];
    $ret = json_encode([ 'code'=>0 ]);
    $con->send($ret);
}

// 发送题目都某一“对战”
function send_q($con_id) {
    global $worker, $pk_list, $con, $max_id;
    $req_con = $worker->connections[$con_id];
    $acc_con_id = $pk_list[$con_id]['acc_con_id'];
    $acc_con =  $worker->connections[$acc_con_id];

    /*假设直接生成5个候选题id 似乎很高效。存在的问题：
    5个id中只要有一个无效（被删除的id），就要再重新生成候选 重新执行sql
    */
    $q = null;
    while(!$q || in_array($q['id'], $pk_list[$con_id]['qids'])) {
        $sel_id = (int)rand(1, $max_id);
        $sql = "select * from questions where id = $sel_id";
        $q = $con->query($sql)->fetch_assoc();
    }
    $pk_list[$con_id]['qids'][] = $q['id'];  // 标记为已用题目
    $arr = ['code' => 2, 'q' => $q];  // code=2：分发题目
    $str_q = json_encode($arr);
    $req_con->send($str_q);
    $acc_con->send($str_q);
}

function process($con, $data) {
    switch ($data->code) {
        case 0: {
            $con_id = find_con($data->my_id);
            // 是否有人邀请自己
            if ($con_id) {
                accept($con, $con_id);
            } else {
                req_pk($con, $data);
            }
        } break;
    }
}

// 运行worker
Worker::runAll();