<?php 
require_once('db_inc.php');
require_once('utils.php');

$usr_id = $_SESSION['usr_id'];
$stu_id = strtoupper($usr_id);
$stu_id = mb_substr($stu_id, 1);

//カテゴリー別のGPAを計算する。
$sql = <<<EOM
SELECT sub_id ,category_id, category_name ,SUM((CASE WHEN grade=1 THEN 4 WHEN grade=2 THEN 3 WHEN grade=3 THEN 2 WHEN grade=4 THEN 1 ELSE null END)*sub_unit)/SUM(sub_unit) AS cat_gpa FROM tb_student NATURAL JOIN tb_course NATURAL JOIN tb_subject NATURAL JOIN tb_category cat WHERE stu_id = '{$stu_id}' GROUP BY cat.category_id ORDER BY cat_gpa DESC 
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$categorygpa = [];
$rank = 1;
while($row){
	$category_id = $row['category_id'];
	$categorygpa[$category_id] = [
		'category_name' => $row['category_name'], 
		'cat_gpa' => $row['cat_gpa'],
		'rank'=> $rank
	];
	$row = $rs->fetch_assoc();
	$rank ++;
}
// var_dump($categorygpa);

$category_1 = gettotalpointCategoryTT($stu_id, 1);
$category_3 = gettotalpointCategoryTT($stu_id, 3);
var_dump($category_1);
var_dump($category_3);






?>