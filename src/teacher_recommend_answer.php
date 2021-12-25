<?php
require_once('db_inc.php');
include('data.php');
$rcm_id = $_GET['rcm_id'];
$rec_id = $_GET['rec_id'];

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
<hr style="border:0;border-top:1px solid black;">





<?php


$sql = <<<EOM
select * from tb_recommend natural join tb_student where rcm_id = '{$rcm_id}';
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$rcm_stu = [
  'stu_id' => $row['stu_id'],
  'stu_name' => $row['stu_name'],
  'ad_year' => $row['ad_year'],
  'stu_mail' => $row['stu_mail'],
  'rcm_deadline' => $row['rcm_deadline'],
  'rcm_result' => $row['rcm_result'],
  'rcm_acomment' => $row['rcm_acomment']
];

$stu_id = $rcm_stu['stu_id'];
$sql = <<<EOM
  SELECT *,round(SUM(grade*sub_unit)/SUM(sub_unit) , 2) AS gpa from tb_course NATURAL JOIN tb_subject WHERE stu_id = '{$stu_id}'
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
if($row){
  $rcm_stu['gpa'] = $row['gpa'];
}

?>
<div class="main">
	<div class="tablearea">
	<div>
		<h2>推薦詳細(返答状況)</h2>
	</div>
    <table class="table table-sm table-bordered">
      <tbody>
        <tr>
          <th scope="row" width="25%" class="table-secondary">学籍番号</th>
          <td><?= $rcm_stu['stu_id']; ?></td>
        </tr>
        <tr>
          <th scope="row" class="table-secondary">氏名</th>
          <td><?= $rcm_stu['stu_name']; ?></td>
        </tr>
        <tr>
        	<?php
        	$year = $fake_year - $rcm_stu['ad_year'];
        	?>
          <th scope="row" class="table-secondary">学年</th>
          <td><?= $school_grade[$year];?></td>
        </tr>
        <tr>
          <th scope="row" class="table-secondary">GPA</th>
          <td><?= $rcm_stu['gpa']; ?></td>
        </tr>
        <tr>
          <th scope="row" class="table-secondary">メールアドレス</th>
          <td><?= $rcm_stu['stu_mail']; ?></td>
        </tr>
        <tr>
          <th scope="row" class="table-secondary">返答期日</th>
          <td><?= $rcm_stu['rcm_deadline']; ?></td>
        </tr>
        <tr>
        	<?php
        	if($rcm_stu['rcm_result']){
	    		if($rcm_stu['rcm_result'] == 1){
	    			$result = '了承';
	    		}
	    		if($rcm_stu['rcm_result'] == 2){
	    			$result = '拒否';
	    		}
	    	}else{
	    		$result = '未回答';
	    	}
        	?>
          <th scope="row" class="table-secondary">返答結果</th>
          <td><?= $result; ?></td>
        </tr>
        <?php if($rcm_stu['rcm_result']): ?>
        <tr>
          <th scope="row" class="table-secondary">返答コメント</th>
          <td><?= $rcm_stu['rcm_acomment']; ?></td>
        </tr>
    	<?php endif; ?>

      </tbody>
    </table>
  </div>
</div>
