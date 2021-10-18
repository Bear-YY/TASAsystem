<?php
require_once('db_inc.php');
$dpt_id = $_POST['dpt_id'];
$category_id = $_POST['category_id'];
$sub_name = $_POST['sub_name'];
$sub_unit = $_POST['sub_unit'];
$get_year = $_POST['get_year'];
$sub_section = $_POST['sub_section'];

echo $dpt_id; echo '<br>';
echo $category_id; echo '<br>';
echo $sub_name; echo '<br>';
echo $sub_unit; echo '<br>';
echo $get_year; echo '<br>';
echo $sub_section; echo '<br>';

$sql = <<<EOM
INSERT INTO tb_subject(dpt_id,category_id,sub_name,sub_unit,get_year,sub_section) 
VALUES('{$dpt_id}','{$category_id}','{$sub_name}','{$sub_unit}','{$get_year}','{$sub_section}')
EOM;

$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$url = '?do=admin_subject_list';
header('Location:'.$url);


?>