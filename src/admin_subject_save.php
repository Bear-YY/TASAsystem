<?php
require_once('db_inc.php');
$si = $_POST['sub_id'];
$di = $_POST['dpt_id'];
$ci = $_POST['category_id'];
$sn = $_POST['sub_name'];
$su = $_POST['sub_unit'];
$gy = $_POST['get_year'];
$ss = $_POST['sub_section'];
$sql = 'INSERT INTO';
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$url = '?do=admin_subject_list';
header('Location:'.$url);


?>