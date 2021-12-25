<?php
require_once('db_inc.php');
require_once('data.php');
require_once('utils.php');
$rec_id = $_GET['rec_id'];
// echo $rec_id;

$sql = <<<EOM
SELECT * FROM tb_student NATURAL JOIN tb_course NATURAL JOIN tb_subject NATURAL JOIN tb_timetable tt,tb_recruitment rec
WHERE grade >= 3 AND tt.tt_id = rec.tt_id AND rec_id = '{$rec_id}' AND stu_id NOT IN
(SELECT rcm.stu_id FROM tb_recommend rcm, tb_student stu NATURAL JOIN tb_recruitment rec
WHERE rcm.stu_id = stu.stu_id AND rcm.rec_id = '{$rec_id}')
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
if($students){
  foreach ($students as $key => $value) {
    //応募数を$studentsに加える。
    $sql = <<<EOM
      SELECT * from tb_application where stu_id = '{$key}' and rec_id = '{$rec_id}'
    EOM;
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    if($row){
      $students[$key]['app_result'] = $row['app_result'];
    }else{
      $students[$key]['app_result'] = 9; //採用待ち:0、採用:1、応募撤回:3なのでとりあえず重複しない値で初期化
    }
  }

	foreach ($students as $key => $value) {
    //GPAを$studentsに加える。
    $sql = <<<EOM
      SELECT *,round(SUM(grade*sub_unit)/SUM(sub_unit) , 2) AS gpa from tb_course NATURAL JOIN tb_subject WHERE stu_id = '{$key}'
    EOM;
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    if($row){
      $students[$key]['gpa'] = $row['gpa'];
    }
  }
	// var_dump($students); echo '<br>';
	$students = sortByKey('gpa', SORT_DESC, $students);
	// var_dump($students);
}

$sql = <<<EOM
SELECT * FROM tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_teacher NATURAL JOIN tb_subject
WHERE rec_id = '{$rec_id}' AND rec.tt_id = tt.tt_id
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
?>
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
            <th scope="row" width="50%" class="table-secondary">募集役割</th>
            <td><?= $role[$row['role_id']]; ?></td>
          </tr>
          <tr>
            <th scope="row" class="table-secondary">募集人数</th>
            <td width="50%"><?= $row['rec_num']; ?>人</td>
          </tr>
        </tbody>
      </table>
  </div>
</div>
<table class="table table-borderless">
	<tbody>
		<tr>
			<th scope="row">教員コメント</th>
			<td style="white-space:pre-wrap;"><?= $row['rec_comment'] ;?></td>
		</tr>
	</tbody>
</table>
<hr style="border:0;border-top:1px solid black;">

 <h3>成績条件を満たす学生</h3>
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">学籍番号</th>
      <th scope="col">氏名</th>
      <th scope="col">学年</th>
      <th scope="col">GPA</th>
      <th scope="col"></th>
      <th scope="col">応募の有無</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($students as $key => $value): ?>
	<tr>
		<td scope="col"><?=$key;?></td>
		<td scope="col"><?=$value['stu_name'];?></td>
		<?php $year = $fake_year - $value['ad_year'];  ?>
		<td scope="col"><?=$school_grade[$year];?></td>
		<td scope="col"><?=$value['gpa'];?></td>
		<td>
		<a class="btn btn-secondary" href="?do=teacher_recommend_detail&rec_id=<?= $rec_id;?>&stu_id=<?= $key;?>" role="button">詳細</a>
		</td>
    <?php if($value['app_result'] == 9): ?>
      <td scope="col" class="table-secondary">無</td>
    <?php else: ?>
      <td scope="col" class="table-primary">有</td>
    <?php endif; ?>
	</tr>
<?php endforeach; ?>
  </tbody>
</table>
