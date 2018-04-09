<?php
use Workerman\Worker;
require_once './Workerman/Autoloader.php';

$worker = new Worker('websocket://0.0.0.0:8686');

$worker->onMessage = function($connection, $data)
{
    $connection->send("hello");
};

// 运行worker
Worker::runAll();