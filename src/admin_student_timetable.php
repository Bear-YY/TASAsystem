<?php 
require_once('db_inc.php');
require_once('data.php');

$stu_id = $_GET['stu_id'];
$sql = "SELECT * FROM tb_student WHERE stu_id = '{$stu_id}'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$stu_name = $row['stu_name'];
$stu_id = $row['stu_id'];

//応募している時間割を取得
$sql = <<<EOM
SELECT * FROM tb_application NATURAL JOIN tb_recruitment rec NATURAL JOIN tb_teacher, tb_timetable tt NATURAL JOIN tb_subject
WHERE app_id IN
	(SELECT app_id 
	FROM tb_application 
	WHERE stu_id = '{$stu_id}') 
AND rec.tt_id = tt.tt_id
ORDER BY app_result DESC ,semester ,tt_weekday ,tt_timed
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$timetable = [];
while($row){
	$app_id = $row['app_id'];
	$timetable[$app_id] = [
		'app_result' => $row['app_result'],
		'sub_name' => $row['sub_name'],
		'semester' => $row['semester'],
		'tt_weekday' => $row['tt_weekday'],
		'tt_timed' => $row['tt_timed'],
		'tea_name' => $row['tea_name'],
		'tea_id' => $row['tea_id'],

	];
	$row = $rs->fetch_assoc();
}

//推薦をされている時間割を取得
$sql = <<<EOM
SELECT * FROM tb_recommend NATURAL JOIN tb_recruitment rec NATURAL JOIN tb_teacher, tb_timetable tt NATURAL JOIN tb_subject
WHERE rcm_id IN
  (SELECT rcm_id 
  FROM tb_recommend 
  WHERE stu_id = '{$stu_id}') 
AND rec.tt_id = tt.tt_id
ORDER BY rcm_result DESC ,semester ,tt_weekday ,tt_timed
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$rcmtt = [];
while($row){
  $rcm_id = $row['rcm_id'];
  $rcmtt[$rcm_id] = [
    'rcm_result' => $row['rcm_result'],
    'sub_name' => $row['sub_name'],
    'semester' => $row['semester'],
    'tt_weekday' => $row['tt_weekday'],
    'tt_timed' => $row['tt_timed'],
    'tea_name' => $row['tea_name'],
    'tea_id' => $row['tea_id'],

  ];
  $row = $rs->fetch_assoc();
}
?>

<?php if($timetable): ?>
<h3>応募時間割&nbsp;&nbsp;<?php echo $stu_id.'-'.$stu_name?></h3>
<table class="table table-bordered">
  <thead class="thead-dark"> 
    <tr>
        <th scope="col">応募状況</th>
        <th scope="col">科目名</th>
        <th scope="col">担当教員</th>
        <th scope="col">学期</th>
        <th scope="col">曜日</th>
        <th scope="col">時限</th>
      </tr>
  </thead>  
  <tbody>
  	<?php foreach($timetable as $key => $value): ?>
    <tr>
       <?php if($value['app_result'] == 2): ?>
       	<th class="table-denger" width="10%" scope="row">不採用
       <?php elseif($value['app_result'] == 1): ?>
       	<th class="table-primary" width="10%" scope="row">採用中
       <?php else: ?>
       	<th class="table-secondary" width="10%" scope="row">採用待ち
       <?php endif; ?>
       <td><?=$value['sub_name']; ?></td>
       <td><a href="?do=admin_teacher_timetable&tea_id=<?= $value['tea_id'];?>"><?=$value['tea_name']; ?></a></td>

       <td><?=$semesters[$value['semester']]; ?></td>
       <td><?=$weekdays[$value['tt_weekday']]; ?></td>
       <td><?=$times[$value['tt_timed']]; ?></td>
       <!-- <td align="center"><a class="btn btn-secondary" href="?do=admin_teacher_recommend&rcm_id=<?= $key; ?>" role="button">推薦者</a></td> -->
    </tr>
 	<?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
<h5><?= $stu_name;?>さんはTA・SAの応募をしていません。</h5>
<?php endif; ?>


<?php if($rcmtt): ?>
<hr style="border:0;border-top:1px solid black;">
<h3>推薦時間割&nbsp;&nbsp;<?php echo $stu_id.'-'.$stu_name?></h3>
<table class="table table-bordered">
  <thead class="thead-dark"> 
    <tr>
        <th scope="col">推薦状況</th>
        <th scope="col">科目名</th>
        <th scope="col">担当教員</th>
        <th scope="col">学期</th>
        <th scope="col">曜日</th>
        <th scope="col">時限</th>
      </tr>
  </thead>  
  <tbody>
    <?php foreach($rcmtt as $key => $value): ?>
    <tr>
       <?php if($value['rcm_result'] == 2): ?>
        <th class="table-danger" width="10%" scope="row">拒否
       <?php elseif($value['rcm_result'] == 1): ?>
        <th class="table-primary" width="10%" scope="row">了承
       <?php else: ?>
        <th class="table-secondary" width="10%" scope="row">未回答
       <?php endif; ?>
       <td><?=$value['sub_name']; ?></td>
       <td><a href="?do=admin_teacher_timetable&tea_id=<?= $value['tea_id'];?>"><?=$value['tea_name']; ?></a></td>

       <td><?=$semesters[$value['semester']]; ?></td>
       <td><?=$weekdays[$value['tt_weekday']]; ?></td>
       <td><?=$times[$value['tt_timed']]; ?></td>
       <!-- <td align="center"><a class="btn btn-secondary" href="?do=admin_teacher_recommend&rcm_id=<?= $key; ?>" role="button">推薦者</a></td> -->
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>