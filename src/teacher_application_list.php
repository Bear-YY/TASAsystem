<?php 
require_once('db_inc.php');
require_once('data.php');
$rec_id = $_GET['rec_id'];

// 応募していて採用決定されてない人のデータ
$sql = <<<EOM
SELECT * FROM tb_application NATURAL JOIN tb_student WHERE rec_id = '{$rec_id}' AND app_result IS NULL ORDER BY stu_gpa DESC
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$usetapps = [];    						//$usetapps (un set applications)
while($row){
	$stu_id = $row['stu_id'];
	$usetapps[$stu_id] = [
		'stu_name' => $row['stu_name'],
		'ad_year' => $row['ad_year'],
		'app_id' => $row['app_id'],
		'app_day' => $row['app_day'],
		'stu_gpa' => $row['stu_gpa']
	];
	$row = $rs->fetch_assoc();
}

//応募していて採用決定された人のデータ
$sql = <<<EOM
SELECT * FROM tb_application NATURAL JOIN tb_student WHERE rec_id = '{$rec_id}' AND app_result = 1 ORDER BY stu_gpa DESC
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$setapps = [];							//$setapps (set applications)
while($row){
	$stu_id = $row['stu_id'];
	$setapps[$stu_id] = [
		'stu_name' => $row['stu_name'],
		'ad_year' => $row['ad_year'],
		'app_id' => $row['app_id'],
		'app_day' => $row['app_day'],
		'stu_gpa' => $row['stu_gpa']
	];
	$row = $rs->fetch_assoc();
}
// var_dump($setapps);
// var_dump($usetapps);

//募集をしてる時間割情報の取得
$sql = <<<EOM
SELECT * FROM tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_teacher NATURAL JOIN tb_subject
WHERE rec_id = '{$rec_id}' AND rec.tt_id = tt.tt_id
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();

?>
<article>
	<div class="main">
		

<div class="tablearea-sm">
	<div>
		<h2>募集時間割</h2>
	</div>
    <table class="table table-sm table-bordered">
      <tbody>
        <tr>
          <th scope="row" width="25%" class="table-secondary">科目名</th>
          <td><?= $row['sub_name']; ?></td>
        </tr>
        <tr>
          <th scope="row" class="table-secondary">担当教員</th>
          <td><?= $row['tea_name']; ?></td>
        </tr>
        <tr>
          <th scope="row" class="table-secondary">学期</th>
          <td><?= $semesters[$row['semester']];?></td>
        </tr>
        <tr>
          <th scope="row" class="table-secondary">曜日</th>
          <td><?= $weekdays[$row['tt_weekday']]; ?></td>
        </tr>
        <tr>
          <th scope="row" class="table-secondary">時限</th>
          <td><?= $times[$row['tt_timed']]; ?></td>
        </tr>
        <tr>
          <th scope="row" class="table-secondary">募集役割</th>
          <td><?= $role[$row['role_id']]; ?></td>
        </tr>
        <tr>
          <th scope="row" class="table-secondary">募集人数</th>
          <td><?= $row['rec_num']; ?>人</td>
        </tr>
        
      </tbody>
    </table>
  </div>
<hr style="border:0;border-top:1px solid black;">

<?php



if((!$usetapps) && (!$setapps)){
	echo '<h4>応募している学生はまだいません。</h4>';
	echo '<h4>↓学生を推薦する際はこちらから行ってください。</h4>';
}else{
	echo '<h2>応募者一覧</h2>';
}
?>
<?php if($setapps): ?>
<h3>採用した学生</h3>
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
    　<th scope="col"></th>
      <th scope="col">学籍番号</th>
      <th scope="col">氏名</th>
      <th scope="col">学年</th>
      <th scope="col">応募日</th>
      <th scope="col">GPA</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>

<?php 
	foreach ($setapps as $key => $value):
	echo '<form action="?do=teacher_application_detail&app_id='.$value['app_id'].'" method="post">';
	echo '<input type="hidden" name="sub_name" value="'.$row['sub_name'].'">';
	echo '<input type="hidden" name="tea_name" value="'.$row['tea_name'].'">';
	echo '<input type="hidden" name="semester" value="'.$row['semester'].'">';
	echo '<input type="hidden" name="tt_weekday" value="'.$row['tt_weekday'].'">';
	echo '<input type="hidden" name="tt_timed" value="'.$row['tt_timed'].'">';
	echo '<input type="hidden" name="role_id" value="'.$row['role_id'].'">';
	echo '<input type="hidden" name="rec_num" value="'.$row['rec_num'].'">';

?>

		<tr>
			<td scope="col">
				<h4><span class="badge badge-primary">採用中</span></h4>
			</td>
<?php
			print('<td scope="col">'.$key.'</td>');
		  print('<td scope="col">'.$value['stu_name'].'</td>');
		  $stu_year = $fake_year - $value['ad_year'];
		  print('<td scope="col">'.$school_grade[$stu_year].'</td>');
			print('<td scope="col">'.$value['app_day'].'</td>');	
			print('<td scope="col">'.$value['stu_gpa'].'</td>');	
		  print('<td align="center">
		  			<button type="submit" class="btn btn-secondary btn-sm" role="button">詳細</button>
		  			</td>');
			echo '</form>';
?>
		</tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php 
endif; 

if($usetapps): ?>
<h3>採用の判断をしていない学生</h3>
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
    　<th scope="col"></th>
      <th scope="col">学籍番号</th>
      <th scope="col">氏名</th>
      <th scope="col">学年</th>
      <th scope="col">応募日</th>
      <th scope="col">GPA</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
<?php 
foreach ($usetapps as $key => $value): 
echo '<form action="?do=teacher_application_detail&app_id='.$value['app_id'].'" method="post">';
echo '<input type="hidden" name="sub_name" value="'.$row['sub_name'].'">';
echo '<input type="hidden" name="tea_name" value="'.$row['tea_name'].'">';
echo '<input type="hidden" name="semester" value="'.$row['semester'].'">';
echo '<input type="hidden" name="tt_weekday" value="'.$row['tt_weekday'].'">';
echo '<input type="hidden" name="tt_timed" value="'.$row['tt_timed'].'">';
echo '<input type="hidden" name="role_id" value="'.$row['role_id'].'">';
echo '<input type="hidden" name="rec_num" value="'.$row['rec_num'].'">';

?>

		<tr>
			<td scope="col">
				<span class="badge badge-primary"></span>
			</td>
<?php
				  print('<td scope="col">'.$key.'</td>');
				  print('<td scope="col">'.$value['stu_name'].'</td>');
				  $year = $fake_year - $value['ad_year'];
				  print('<td scope="col">'.$year.'</td>');
				  print('<td scope="col">'.$value['app_day'].'</td>');
				  print('<td scope="col">'.$value['stu_gpa'].'</td>');
				  print('<td align="center">
		  			<button type="submit" class="btn btn-secondary btn-sm" role="button">詳細</button>
		  			</td>');
				  echo '</form>';
?>
		</tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php 
endif; 
?>
<a class="btn btn-secondary" href="?do=teacher_reccomend&rec_id=<?= $rec_id;?>" role="button">学生を推薦をする</a>
	</div>
</article>
