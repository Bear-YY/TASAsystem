<?php 
require_once('db_inc.php');
$qttl = $_POST['que_title'];
$sql = "INSERT INTO tb_questionnaire(que_title) VALUES('{$qttl}')";
$rs = $conn->query($sql);

header('Location:?do=admin_questionnaire_list'); 


 ?>