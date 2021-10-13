<?php 
require_once('db_inc.php');
$rcm_acomment = $_POST['rcm_acomment'];
$rcm_result = $_POST['rcm_result'];
$rcm_id = $_POST['rcm_id'];

echo $rcm_acomment;
echo $rcm_result; 
echo $rcm_id; 

$sql = <<<EOM
UPDATE tb_recommend SET rcm_result = '{$rcm_result}', rcm_acomment = '{$rcm_acomment}' 
WHERE rcm_id='{$rcm_id}';
EOM;
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$url = '?do=student_home';
header('Location:'.$url);


?>