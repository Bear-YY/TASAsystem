<?php 
require_once
$app_id = $_GET['app_id'];

$sql = <<<EOM
SELECT * FROM tb_application NATURAL JOIN tb_student
WHERE app_id = '{$app_id}'
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();



 ?>