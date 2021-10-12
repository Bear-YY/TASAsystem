<?php 
require_once('db_inc.php');
$usr_id = $_SESSION['usr_id'];
$stu_id = strtoupper($usr_id); //全部大文字
$stu_id = mb_substr($stu_id, 1);  //頭の一文字を消す(細かい使い方は調べましょう)

$rec_id = $_POST['rec_id'];
$date = strtotime("+12 year", time());   //日付を取得(12年後を取得)
$app_day = date('Y-m-d', $date);		 //表示形式を'Y-m-d'(year-month-day)にする
$app_comment = $_POST['app_comment'];

echo $stu_id;
echo $rec_id;   //日付を取得(12年後を取得)
echo $app_day;		 //表示形式を'Y-m-d'(year-month-day)にする
echo $app_comment;

$sql = <<<EOM
INSERT INTO tb_application(stu_id,rec_id,app_day,app_comment) 
VALUES('{$stu_id}','{$rec_id}','{$app_day}','{$app_comment}')
EOM;

$rs = $conn->query($sql);
$url = '?do=student_home';
header('Location:'.$url);
 ?>