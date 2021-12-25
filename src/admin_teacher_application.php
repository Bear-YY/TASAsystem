<?php
require_once('db_inc.php');
require_once('data.php');
$rec_id = $_GET['rec_id'];

//応募している学生の情報を取得
$sql = <<<EOM
SELECT * FROM tb_application NATURAL JOIN tb_student WHERE rec_id = '{$rec_id}' ORDER BY app_result DESC, stu_id
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$students = [];
while($row){
	$stu_id = $row['stu_id'];
	$students[$stu_id] = [
		'stu_name' => $row['stu_name'],
		'dpt_id' => $row['dpt_id'],
		'stu_sex' => $row['stu_sex'],
		'ad_year' => $row['ad_year'],
		'app_result' => $row['app_result'],
		'stu_mail' => $row['stu_mail']
	];
	$row = $rs->fetch_assoc();
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
            <th scope="row" width="50%"class="table-secondary">募集役割</th>
            <td width="50%"><?= $role[$row['role_id']]; ?></td>
          </tr>
          <tr>
            <th scope="row" class="table-secondary">募集人数</th>
            <td><?= $row['rec_num']; ?>人</td>
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

<?php if($students): ?>
	<hr style="border:0;border-top:1px solid black;">
	<h3>応募学生一覧</h3>
	<table class="table table-bordered">
	  <thead class="thead-dark">
	    <tr>
	    	<th scope="col"></th>
	        <th scope="col">学籍番号</th>
	        <th scope="col">氏名</th>
	        <th scope="col">学科ID</th>
	        <th scope="col">学年</th>
	        <th scope="col">性別</th>
	        <th scope="col">メールアドレス</th>
	      </tr>
	  </thead>
	  <tbody>
	  	<?php foreach($students as $key => $value): ?>
	    <tr>
	    	<?php if($value['app_result'] == 3): ?>
	    		<th class="table-warning" width="10%" scope="row">応募撤回
	    	<?php elseif($value['app_result'] == 2): ?>
	    		<th class="table-danger" width="10%" scope="row">不採用
	    	<?php elseif($value['app_result'] == 1): ?>
	    		<th class="table-primary" width="10%" scope="row">採用中
	    	<?php else: ?>
	    		<th class="table-secondary" width="10%" scope="row">判断無し
	       	<?php endif; ?>
	       </td>
	       <td><?= $key;?></td>
	       <td><a href="?do=admin_student_timetable&stu_id=<?= $key ;?>"><?= $value['stu_name'];?></a></td>
	       <td><?= $value['dpt_id'];?></td>
	       <?php $year = $fake_year - $value['ad_year']; ?>
	       <td><?= $school_grade[$year];?></td>
	       <td><?= $sex[$value['stu_sex']];?></td>
	       <td><?= $value['stu_mail'];?></td>
	    </tr>
	 	<?php endforeach; ?>
	  </tbody>
	</table>
<?php else: ?>
	<p>応募している学生はまだいません。</p>
<?php endif; ?>
