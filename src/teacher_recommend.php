<?php 
require_once('db_inc.php');
require_once('data.php');
$rec_id = $_GET['rec_id'];
echo $rec_id;

$sql = <<<EOM
SELECT * FROM tb_student NATURAL JOIN tb_course NATURAL JOIN tb_subject NATURAL JOIN tb_timetable tt,tb_recruitment rec
WHERE grade <= 2 AND tt.tt_id = rec.tt_id AND rec_id = '{$rec_id}' AND stu_id NOT IN
(SELECT rcm.stu_id FROM tb_recommend rcm, tb_student stu NATURAL JOIN tb_recruitment rec
WHERE rcm.stu_id = stu.stu_id AND rcm.rec_id = '{$rec_id}' AND rcm.rcm_result IS NULL) ORDER BY stu_gpa DESC
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$students = [];    						//$students (un set applications)
while($row){
	$stu_id = $row['stu_id'];
	$students[$stu_id] = [
		'stu_name' => $row['stu_name'],
		'ad_year' => $row['ad_year'],
		'stu_gpa' => $row['stu_gpa']
	];
	$row = $rs->fetch_assoc();
}

var_dump($students);
?>

 <h3>成績条件を満たす学生</h3>
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">学籍番号</th>
      <th scope="col">氏名</th>
      <th scope="col">学年</th>
      <th scope="col">GPA</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
<?php 
foreach ($students as $key => $value): 
?>
	<tr>
<?php
			  print('<td scope="col">'.$key.'</td>');
			  print('<td scope="col">'.$value['stu_name'].'</td>');
			  $year = $fake_year - $value['ad_year'];
			  print('<td scope="col">'.$year.'</td>');
			  print('<td scope="col">'.$value['stu_gpa'].'</td>');
			  echo '<td>';
			  echo '<a class="btn btn-secondary" href="?do=teacher_recommend_detail&rec_id='.$rec_id.'&stu_id='.$key.'" role="button">詳細</a>';
			  echo '</td>';
?>
		</tr>
<?php endforeach; ?>
  </tbody>
</table>