<?php 
require_once('db_inc.php');
require_once('data.php');
$tea_id = $_SESSION['usr_id'];

//募集している時間割情報を取得
$sql = 
"SELECT * FROM tb_teacher tea NATURAL JOIN tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_subject sub
WHERE rec.tea_id = '{$tea_id}' AND rec.tt_id = tt.tt_id ORDER BY semester , tt_weekday , tt_timed";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();                    //募集してる時間割情報(それ以外の時間割は募集してない)
$rec = [];
while($row){
	$rec_id = $row['rec_id'];
	$rec[$rec_id] = [	
		'sub_name' => $row['sub_name'],
		'semester' => $row['semester'],
		'tt_weekday' => $row['tt_weekday'],
		'tt_timed' => $row['tt_timed'],
		'rec_num' => $row['rec_num'],
		'tt_id' => $row['tt_id']
	];
	$row= $rs->fetch_assoc();
}

//募集している人数を取得
$sql = <<<EOM
select rec_id , COUNT(*) as app_num from tb_recruitment NATURAL JOIN tb_application where tea_id = '{$tea_id}' group by rec_id 
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$app = [];
while($row){
	$rec_id = $row['rec_id'];
	$app[$rec_id] = [	
		'app_num' => $row['app_num']
	];
	$row= $rs->fetch_assoc();
}


//募集してない時間割情報を取得
$sql = <<<EOM
SELECT * FROM tb_timetable NATURAL JOIN tb_subject WHERE tt_id NOT IN
(SELECT tt_id FROM tb_teacher NATURAL JOIN tb_recruitment WHERE tea_id = '{$tea_id}') AND tea_id = '{$tea_id}' ORDER BY semester , tt_weekday , tt_timed
EOM;

$rs = $conn->query($sql);
$row = $rs->fetch_assoc();                    //募集してる時間割情報(それ以外の時間割は募集してない)
$norec = [];
while($row){
	$tt_id = $row['tt_id'];
	$norec[$tt_id] = [
		'sub_name' => $row['sub_name'],
		'semester' => $row['semester'],
		'tt_timed' => $row['tt_timed'],
		'tt_weekday' => $row['tt_weekday']
	];
	$row= $rs->fetch_assoc();
}

?>
<h3>担当時間割一覧</h3>

<?php if($rec): ?>
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col" width="8%">募集状況</th>
      <th scope="col">科目名</th>
      <th scope="col">学期</th>
      <th scope="col">曜日</th>
      <th scope="col">時限</th>
      <th scope="col">募集人数</th>
      <th scope="col">応募人数</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
<?php foreach($rec as $key => $value): ?>
		<tr>
			<td scope="col" align="center">
				<span class="badge badge-primary">募集中</span></td>

<?php
					print('<td scope="col">'.$value['sub_name'].'</td>');
				  print('<td scope="col">'.$semesters[$value['semester']].'</td>');
				  print('<td scope="col">'.$weekdays[$value['tt_weekday']].'</td>');
				  print('<td scope="col">'.$times[$value['tt_timed']].'</td>');
				  print('<td scope="col">'.$value['rec_num'].'人</td>');
				  if(isset($app[$key]['app_num'])){
				  	echo '<td scope="col">'.$app[$key]['app_num'].'人</td>';
				  }else{
				  	echo '<td scope="col">0人</td>';
				  }
?>
			<td scope="col" align="center">
				<!-- <a href="?do=teacher_recruitment_add&tt_id=<?= $value['tt_id'];?>" class="badge badge-info">編集</a> -->
				<a href="?do=teacher_recruitment_add&tt_id=<?= $value['tt_id'];?>" class="btn btn-sm btn-info" role="button">編集</a>
			</td>
			<td scope="col" align="center">
				<?php 
				// echo '<a href="?do=teacher_application_list&rec_id='.$key.'" class="badge badge-info">募集者確認</a>';
				echo '<a href="?do=teacher_application_list&rec_id='.$key.'" class="btn btn-sm btn-info" role="button">応募・推薦者一覧</a>';
				?>
			</td>
			</tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php 
endif; 

if($rec && $norec): ?>
<hr style="border:0;border-top:1px solid black;">
<?php 
endif;

if($norec): 
?>
<table class="table table-bordered">	
  <thead class="thead-light">
    <tr>
      <th scope="col" width="8%">募集状況</th>
      <th scope="col">科目名</th>
      <th scope="col">学期</th>
      <th scope="col">曜日</th>
      <th scope="col">時限</th>
    </tr>
  </thead>
  <tbody>
<?php foreach($norec as $key => $value): ?>
	<tr>
	<td scope="col" align="center">
<?php
echo '<a href="?do=teacher_recruitment_add&tt_id='.$key.'" class="badge badge-danger">募集する</a>';
?>
	</td>
<?php 
	print('<td scope="col">'.$value['sub_name'].'</td>');
	print('<td scope="col">'.$semesters[$value['semester']].'</td>');
	print('<td scope="col">'.$weekdays[$value['tt_weekday']].'</td>');
	print('<td scope="col">'.$times[$value['tt_timed']].'</td>');
	print('</tr>');
?>
<?php endforeach; ?>
  </tbody>
</table>

<?php endif; ?>
