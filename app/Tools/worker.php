<?php
use Workerman\Worker;
require_once './Workerman/Autoloader.php';

$str = file_get_contents('db_info.json');
$info = json_decode($str);
extract($info);
$con = new mysqli($host, $username, $psw, $dbname);
$worker = new Worker('websocket://0.0.0.0:8686');
$pk_list = [];  // element = 'req_con_id'=>['req_id', 'acc_id', 'acc_con_id', 'status', 'qids']
$worker->onMessage = function($con, $str) {
    $data = json_decode($str);
    global $pk_list; var_dump($pk_list);
    process($con, $data);
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
}

// 自己发起挑战
function req_pk($data, $con) {
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
    global $worker, $pk_list;
    $req_con = $worker->connections[$con_id];
    $acc_con =  $worker->connections[ $pk_list[$con_id]['acc_con_id'] ];
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