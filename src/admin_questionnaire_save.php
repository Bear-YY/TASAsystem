<?php 
$act = $_GET['act'];
require_once('db_inc.php');
if($act == 'insert'){
    $qttl = $_POST['que_title'];
    $sql = "INSERT INTO tb_questionnaire(que_title) VALUES('{$qttl}')";
    $rs = $conn->query($sql);
    if (!$rs) die('エラー: ' . $conn->error);
}

if($act == 'delete'){
    $que_id = $_GET['que_id'];
    echo $que_id;
    $sql = "DELETE FROM tb_questionnaire WHERE que_id = '{$que_id}'";
    $rs = $conn->query($sql);
    if (!$rs) die('エラー: ' . $conn->error);
}

if($act == 'update'){
    $que_id = $_GET['que_id'];
    $qttl = $_POST['que_title'];
    $sql = "UPDATE tb_questionnaire SET que_title = '{$qttl}' WHERE que_id = '{$que_id}'";
    $rs = $conn->query($sql);
    if (!$rs) die('エラー: ' . $conn->error);
}

header('Location:?do=admin_questionnaire_list'); 


 ?>