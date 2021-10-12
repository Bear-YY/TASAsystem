<?php 
require_once('db_inc.php');
$tt_id = $_GET['tt_id'];
$role_id = $_POST['role_id'];
$tea_id = $_SESSION['usr_id'];
$rec_comment = $_POST['rec_comment'];
$rec_num = $_POST['rec_num'];

// 本システムでは学生情報などが2033年のものであると仮定している。
$date = strtotime("+12 year", time());
$date = date('Y-m-d', $date);

$ques = array_slice($_POST, 3, NULL, TRUE );

echo $date;
//var_dump($ques);

$sql = <<<EOM
INSERT INTO tb_recruitment(tt_id,role_id,tea_id,rec_day,rec_comment,rec_num)
VALUES('{$tt_id}','{$role_id}','{$tea_id}','{$date}','{$rec_comment}','{$rec_num}')
EOM;
$rs = $conn->query($sql);

foreach ($ques as $key => $value) {
    $sql ="INSERT INTO tb_config(tea_id,que_id,con_value)
        VALUES('{$tea_id}','{$key}','{$value}')";
    $rs = $conn->query($sql);
    if (!$rs) die('エラー: ' . $conn->error);
}
$url = '?do=teacher_home';
header('Location:'.$url);


 ?>