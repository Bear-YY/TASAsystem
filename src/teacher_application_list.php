<?php
require_once('db_inc.php');
require_once('data.php');
$rec_id = $_GET['rec_id'];

// 応募していて判断されてない人のデータ
$sql = <<<EOM
SELECT * FROM tb_application NATURAL JOIN tb_student WHERE rec_id = '{$rec_id}' ORDER BY app_result DESC, stu_id
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$appstudents = [];
while($row){
	$stu_id = $row['stu_id'];
	$appstudents[$stu_id] = [
		'stu_name' => $row['stu_name'],
		'ad_year' => $row['ad_year'],
		'app_id' => $row['app_id'],
		'app_day' => $row['app_day'],
		'app_result' => $row['app_result']
	];
	$row = $rs->fetch_assoc();
}
if($appstudents){
	foreach ($appstudents as $key => $value) {
		//GPAを$appstudentsに加える。
		$sql = <<<EOM
			SELECT *,round(SUM(grade*sub_unit)/SUM(sub_unit) , 2) AS gpa from tb_course NATURAL JOIN tb_subject WHERE stu_id = '{$key}'
			EOM;
			$rs = $conn->query($sql);
			$row = $rs->fetch_assoc();
			if($row){
				$appstudents[$key]['gpa'] = $row['gpa'];
			}
		}
}

//推薦をされた学生の情報を取得
$sql = <<<EOM
SELECT * FROM tb_recommend rcm,tb_student stu NATURAL JOIN tb_recruitment rec
WHERE rcm.stu_id = stu.stu_id AND rcm.rec_id = '{$rec_id}' ORDER BY rcm_result DESC
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


<div class="table-inline">
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
        </tbody>
      </table>
  </div>

  <div class="tablearea-sm">
    <div>
      <h2>募集要項</h2>
    </div>
      <table class="table table-sm table-bordered">
        <tbody>
          <tr>
            <th scope="row" class="table-secondary">募集役割</th>
            <td><?= $role[$row['role_id']]; ?></td>
          </tr>
          <tr>
            <th scope="row" class="table-secondary">募集人数</th>
            <td><?= $row['rec_num']; ?>人</td>
          </tr>
          <tr>
            <th scope="row" class="table-secondary">教員コメント</th>
            <td style="white-space:pre-wrap;"><?= $row['rec_comment']; ?></td>
          </tr>
        </tbody>
      </table>
  </div>
</div>
<!-- 推薦した学生 -->
<?php if($recommends): ?>
<hr style="border:0;border-top:1px solid black;">
<h3>推薦学生</h3>
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
echo '<tr>';
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
if(!$appstudents){
	echo '<h4>応募している学生はまだいません。</h4>';
	echo '<h4>↓学生を推薦する際はこちらから行ってください。</h4>';
}else{
	echo '<h3>応募者一覧</h3>';
}
if($appstudents){
	tableApplication($appstudents, $rec_id);
}

?>
<a class="btn btn-secondary" href="?do=teacher_recommend&rec_id=<?= $rec_id;?>" role="button">学生を推薦をする</a>
	</div>
</article>

<?php
function tableApplication($array, $rec_id){
	include('data.php');
	echo '<table class="table table-bordered">';
		echo '<thead class="thead-dark">';
			echo '<tr>';
				echo '<th scope="col" width="10%"></th>';
				echo '<th scope="col">学籍番号</th>';
				echo '<th scope="col">氏名</th>';
				echo '<th scope="col">学年</th>';
				echo '<th scope="col">応募日</th>';
				echo '<th scope="col">GPA</th>';
				echo '<th scope="col"></th>';
			echo '</tr>';
		echo '</thead>';
	echo '<tbody>';
	foreach ($array as $key => $value):
		echo '<form action="?do=teacher_application_detail&app_id='.$value['app_id'].'&stu_id='.$key.'" method="post">';
			echo '<input type="hidden" name="rec_id" value="'.$rec_id.'">';
			echo '<tr>';
					echo '<td scope="col" align="center"';
				if($value['app_result'] == 1){
					echo ' class="table-primary">';
				}else if($value['app_result'] == 2){
					echo ' class="table-danger">';
				}else if($value['app_result'] == 3){
					echo ' class="table-warning">';
				}else{
					echo ' class="table-secondary">';
				}
				// echo <!-- <h4><span class="badge badge-secondary">判断無し</span></h4> -->
				$judge = [
					0 => '判断無し',
					1 => '採用中',
					2 => '不採用',
					3 => '応募撤回'
				];
				echo '<h5><b>'.$judge[$value['app_result']].'</b></h5>';
				echo '</td>';
				echo '<td scope="col">'.$key.'</td>';
				echo '<td scope="col">'.$value['stu_name'].'</td>';
				$year = $fake_year - $value['ad_year'];
				echo '<td scope="col">'.$school_grade[$year].'</td>';
				echo '<td scope="col">'.$value['app_day'].'</td>';
			  echo '<td scope="col">'.$value['gpa'].'</td>';
				echo '<td align="center">
			  			<button type="submit" class="btn btn-secondary btn-sm" role="button">詳細</button>
			  			</td>';
			echo '</tr>';
		echo '</form>';
	endforeach;
	  echo '</tbody>';
	echo '</table>';
	}
?>
