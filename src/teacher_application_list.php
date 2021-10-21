<?php 
require_once('db_inc.php');
require_once('data.php');
$rec_id = $_GET['rec_id'];

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

// 応募していて判断されてない人のデータ
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

//推薦をされた学生の情報を取得
$sql = <<<EOM
SELECT * FROM tb_recommend rcm,tb_student stu NATURAL JOIN tb_recruitment rec
WHERE rcm.stu_id = stu.stu_id AND rcm.rec_id = '{$rec_id}'
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$recommends = [];							
while($row){
	$rcm_id = $row['rcm_id'];
	$recommends[$rcm_id] = [
		'stu_id' => $row['stu_id'],
		'stu_name' => $row['stu_name'],
		'ad_year' => $row['ad_year'],
		'stu_gpa' => $row['stu_gpa'],
		'rcm_result' => $row['rcm_result']
	];
	$row = $rs->fetch_assoc();
}


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

<?php 

// 推薦した学生
if($recommends):
 ?>
<hr style="border:0;border-top:1px solid black;">
<h3>推薦を送った学生</h3>
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">推薦結果</th>
      <th scope="col">学籍番号</th>
      <th scope="col">氏名</th>
      <th scope="col">学年</th>
      <th scope="col">GPA</th>
      <th scope="col"></th>
      <th scope="col"></th>

    </tr>
  </thead>
  <tbody>
<?php 
foreach ($recommends as $key => $value): 
echo '<form action="?do=teacher_application_detail&rcm_id='.$key.'&stu_id='.$value['stu_id'].'" method="post">';
echo '<input type="hidden" name="rec_id" value="'.$rec_id.'">';

?>
		<tr>
<?php
				  if($value['rcm_result']){
				  	if($value['rcm_result'] == 1){
				  		$result = 'class="table-primary"><h5><b>了承';
				  	}
				  	if($value['rcm_result'] == 2){
				  		$result = 'class="table-danger"><h5><b>拒否';
				  	}
				  }else{
				  	$result = 'class="table-secondary"><h5><b>未回答';
				  }
				  echo '<td width="10%" scope="col" align="center"'.$result.'</b></h5></td>';
				  echo '<td scope="col">'.$value['stu_id'].'</td>';
				  echo '<td scope="col">'.$value['stu_name'].'</td>';
				  $year = $fake_year - $value['ad_year'];
				  echo '<td scope="col">'.$school_grade[$year].'</td>';
				  echo '<td scope="col">'.$value['stu_gpa'].'</td>';
				  echo '<td align="center">';
		  		echo '<button type="submit" class="btn btn-sm btn-secondary" role="button">詳細</button>';
				  echo '</form>';
		  		echo '</td>';
		  		echo '<td align="center">';
		  		echo '<a class="btn btn-sm btn-info" href="?do=teacher_recommend_answer&rcm_id='.$key.'&rec_id='.$rec_id.'" role="button">推薦詳細</a>';
		  		echo '</td>';
?>
		</tr>
<?php endforeach; ?>
  </tbody>
</table>

<?php 
endif;
 ?>

<hr style="border:0;border-top:1px solid black;">
<?php
if((!$usetapps) && (!$setapps)){
	echo '<h4>応募している学生はまだいません。</h4>';
	echo '<h4>↓学生を推薦する際はこちらから行ってください。</h4>';
}else{
	echo '<h1>応募者一覧</h1>';
}
?>




<!-- 採用決定した学生 -->
<?php if($setapps): ?>
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
    　<th scope="col" width="10%">状態</th>
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
	echo '<form action="?do=teacher_application_detail&app_id='.$value['app_id'].'&stu_id='.$key.'" method="post">';
	echo '<input type="hidden" name="rec_id" value="'.$rec_id.'">';
?>

		<tr>
			<td scope="col" align="center" class="table-primary">
				<!-- <h4><span class="badge badge-primary">採用中</span></h4> -->
				<h5><b>採用中</b></h5>
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
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
    　<th scope="col" width="10%"></th>
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
echo '<form action="?do=teacher_application_detail&app_id='.$value['app_id'].'&stu_id='.$key.'" method="post">';
echo '<input type="hidden" name="rec_id" value="'.$rec_id.'">';
?>
		<tr>
			<td scope="col" align="center" class="table-secondary">
				<!-- <h4><span class="badge badge-secondary">判断無し</span></h4> -->
				<h5><b>判断無し</b></h5>
			</td>
<?php
				  print('<td scope="col">'.$key.'</td>');
				  print('<td scope="col">'.$value['stu_name'].'</td>');
				  $year = $fake_year - $value['ad_year'];
				  print('<td scope="col">'.$school_grade[$year].'</td>');
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
<a class="btn btn-secondary" href="?do=teacher_recommend&rec_id=<?= $rec_id;?>" role="button">学生を推薦をする</a>
	</div>
</article>
