<?php 
require_once('db_inc.php');
$tea_id = $_POST['tea_id'];
$sub_id = $_POST['sub_id'];
$semester = $_POST['semester'];
$tt_weekday = $_POST['tt_weekday'];
$tt_timed = $_POST['tt_timed'];
$tt_year = $_POST['tt_year'];
$tt_classnum = $_POST['tt_classnum'];

$sql = "SELECT * FROM tb_teacher WHERE tea_id = '{$tea_id}'";
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$row = $rs->fetch_assoc();
if($row){
	$sql = <<<EOM
	INSERT INTO tb_timetable(tea_id,sub_id,semester,tt_weekday,tt_timed,tt_year,tt_classnum)
	VALUES('{$tea_id}','{$sub_id}','{$semester}','{$tt_weekday}','{$tt_timed}','{$tt_year}','{$tt_classnum}')
	EOM;
	$rs = $conn->query($sql);
	if (!$rs) die('エラー: ' . $conn->error);
	header('Location:?do=admin_timetable&sub_id='.$sub_id);  
}else{
	header('Location:?do=admin_timetable&err=wrong&sub_id='.$sub_id);  
}




?>


