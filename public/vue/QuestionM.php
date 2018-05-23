<?php
/**
 * Created by PhpStorm.
 * User: Luciffer
 * Date: 2018/5/23
 * Time: 11:43
 */

$servername = "120.78.177.169:3306";
$username = "lee";
$password = "122333";
$dbname = "test";


// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
if ($conn->connect_error) {
die("连接失败: " . $conn->connect_error);
}

$sql = "INSERT INTO questions ( id, title, A, B, C,D,answer,type) VALUES ('" 
. $_POST["id"] . " ','" . $_POST["question"] . "','" . $_POST["A"] . "','" .  $_POST["B"] . "','" . $_POST["C"] . "','" . $_POST["D"] ."','" . $_POST["answer"] ."','" . $_POST["type"] . "')";



if ($conn->query($sql) === TRUE) {
    $result= "新记录插入成功";
} else {
    $result= "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
return json_encode($result);


