<?php 
require_once('db_inc.php');
require_once('utils.php');
$tea_id = $_POST['tea_id'];
$stu_id = $_POST['stu_id'];
$rec_id = $_POST['rec_id'];
$today = getToday();
$rcm_deadline = $_POST['rcm_deadline'];
$rcm_comment = $_POST['rcm_comment'];

$sql = <<<EOM
INSERT INTO tb_recommend(tea_id,stu_id,rec_id,rcm_day,rcm_deadline,rcm_comment)
VALUES('{$tea_id}','{$stu_id}','{$rec_id}','{$today}','{$rcm_deadline}','{$rcm_comment}')
EOM;
$rs = $conn->query($sql);
if(!$rs) die('エラー: '. $conn->error);

$url = '?do=teacher_home';
header('Location:'.$url);

 ?>