<?php 
require_once('db_inc.php');

$usr_id = $_SESSION['usr_id'];
$stu_id = strtoupper($usr_id);
$stu_id = mb_substr($stu_id, 1);

// $sql = <<<EOM
// select stu_id ,category_id,category_name ,SUM(sub_unit) as count from tb_student natural join tb_course natural join tb_subject natural join tb_category where stu_id = '{$stu_id}' group by category_id
// EOM;
// $rs = $conn->query($sql);
// $row = $rs->fetch_assoc();
// $fraction = [];
// while($row){
// 	$category_id = $row['category_id'];
// 	$fraction[$category_id] = [
// 		'category_name' => $row['category_name'], 
// 		'count' => $row['count']
// 	];

// 	$row = $rs->fetch_assoc();
// }
// var_dump($fraction);


// $sql = <<<EOM
// select sub_id ,category_id, category_name ,sum((CASE WHEN grade=1 THEN 4 WHEN grade=2 THEN 3 WHEN grade=3 THEN 2 WHEN grade=4 THEN 1 ELSE  null END)*sub_unit) as score from tb_student natural join tb_course natural join tb_subject natural join tb_category cat where stu_id = '{$stu_id}' group by category_id;
// EOM;
// $rs = $conn->query($sql);
// $row = $rs->fetch_assoc();
// $orinumerator = [];
// while($row){
// 	$sub_id = $row['sub_id'];
// 	$oriumerator[$sub_id] = [
// 		'category_name' => $row['category_name'], 
// 		'category_name' => $row['category_name'], 
// 		'grade' => $row['grade'],
// 		'sub_unit' => $row['sub_unit']
// 	];
// 	$row = $rs->fetch_assoc();
// }


$sql = <<<EOM
SELECT sub_id ,category_id, category_name ,SUM((CASE WHEN grade=1 THEN 4 WHEN grade=2 THEN 3 WHEN grade=3 THEN 2 WHEN grade=4 THEN 1 ELSE null END)*sub_unit)/SUM(sub_unit) AS cat_gpa  
FROM tb_student NATURAL JOIN tb_course NATURAL JOIN tb_subject NATURAL JOIN tb_category cat WHERE stu_id = '{$stu_id}' 
GROUP BY category_id;
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$categorygpa = [];
while($row){
	$category_id = $row['category_id'];
	$categorygpa[$category_id] = [
		'category_name' => $row['category_name'], 
		'cat_gpa' => $row['cat_gpa']
	];
	$row = $rs->fetch_assoc();
}



var_dump($categorygpa);

// foreach ($categorygpa as $key => $value) {

// }


?>