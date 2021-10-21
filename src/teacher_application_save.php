<?php 
require_once('db_inc.php');
$app_id = $_GET['app_id'];
$rec_id = $_GET['rec_id'];
echo $app_id;

$sql = <<<EOM
UPDATE tb_application SET app_result= '1' WHERE app_id = '{$app_id}'  
EOM;

$rs = $conn->query($sql);
$url = '?do=teacher_application_list&rec_id='.$rec_id;
header('Location:'.$url);
 ?>