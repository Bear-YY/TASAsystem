<?php 
require_once('db_inc.php');
$usr_id = $_SESSION['usr_id'];
$stu_id = strtoupper($usr_id); //全部大文字
$stu_id = mb_substr($stu_id, 1);  //頭の一文字を消す(細かい使い方は調べましょう)
$act = $_GET['act'];
var_dump($_POST);
var_dump($_GET['act']);

if($act === 'insert'){
    foreach ($_POST as $key => $value) {
        $sql ="INSERT INTO tb_answer(stu_id,que_id,ans_value)
            VALUES('{$stu_id}','{$key}','{$value}')";
        $rs = $conn->query($sql);
        if (!$rs) die('エラー: ' . $conn->error);
    }
}

if($act === 'update'){
    foreach ($_POST as $key => $value) {
        $sql ="UPDATE tb_answer SET ans_value = '{$value}' WHERE que_id = '{$key}' AND stu_id = '{$stu_id}'";
        $rs = $conn->query($sql);
        if (!$rs) die('エラー: ' . $conn->error);
    }
}

$url = '?do=student_home';
header('Location:'.$url);

?>