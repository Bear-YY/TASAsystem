<?php
require_once('db_inc.php');
$app_id = $_GET['app_id'];
$rec_id = $_GET['rec_id'];
$app_result = $_POST['app_result'];
$app_cancmnt = $_POST['app_cancmnt'];
echo $app_id;

$sql = <<<EOM
UPDATE tb_application SET app_result= '{$app_result}' ,app_cancmnt = '{$app_cancmnt}' WHERE app_id = '{$app_id}'
EOM;

$rs = $conn->query($sql);
$url = '?do=teacher_application_list&rec_id='.$rec_id;
header('Location:'.$url);
 ?>
