<?php 
require_once('db_inc.php');
require_once('data.php');
$rec_id = $_GET['rec_id'];
$stu_id = $_GET['stu_id'];
$tea_id = $_SESSION['usr_id'];

$sql = <<<EOM
SELECT * FROM tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_subject sub,tb_course cou NATURAL JOIN tb_student stu
WHERE rec.rec_id = '{$rec_id}' AND stu.stu_id = '{$stu_id}' AND cou.sub_id = sub.sub_id AND rec.tt_id = tt.tt_id
EOM;
$rs = $conn->query($sql);
if(!$rs) die('エラー: '. $conn->error);
$row = $rs->fetch_assoc();
$stu_detail = [];
while($row){
	$stu_detail = [
		'stu_id' => $row['stu_id'],
		'stu_name' => $row['stu_name'],
		'ad_year' => $row['ad_year'],
		'grade' => $row['grade'],
		'stu_mail' => $row['stu_mail'],
		'stu_gpa' => $row['stu_gpa']
	];
	$row = $rs->fetch_assoc();
}

var_dump($stu_detail);

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

<table class="table table-sm table-bordered">
	<thead class="thead-dark"> 
		<tr>
    	  <th scope="col">学籍番号</th>
    	  <th scope="col">氏名</th>
    	  <th scope="col">学年</th>
    	  <th scope="col">GPA</th>
    	  <th scope="col">成績</th>
    	  <th scope="col">メールアドレス</th>
    	  <th scope="col">操作</th>
    	</tr>
	</thead>	
    <tbody>
      <tr>
        <td><?= $stu_detail['stu_id']; ?></td>
        <td><?= $stu_detail['stu_name']; ?></td>
        <?php 
        	$year = $fake_year - $stu_detail['ad_year'];
         ?>
        <td><?= $school_grade[$year]; ?></td>
        <td><?= $stu_detail['stu_gpa']; ?></td>
        <td><?= $grade[$stu_detail['grade']]; ?></td>
        <td><?= $stu_detail['stu_mail']; ?></td>
        <td align="center">
        	<?php  
            echo '<a class="btn btn-danger btn-sm" href="?do=teacher_subject_search&stu_id='.$stu_detail['stu_id'].'" role="button" target="_brank">';
            ?>
              科目別の成績検索 <br> (別ウィンドウが開きます)
            </a>
        </td>
      </tr>
      
    </tbody>
</table>
<form action="?do=teacher_recommend_add" method="post">
<input type="hidden" name="rec_id" value="<?= $rec_id;?>">	
<input type="hidden" name="stu_id" value="<?= $stu_id;?>">	
<input type="hidden" name="tea_id" value="<?= $tea_id;?>">	
<input type="hidden" name="stu_name" value="<?= $stu_detail['stu_name'];?>">	
<input type="hidden" name="ad_year" value="<?= $stu_detail['ad_year'];?>">	
<button type="submit" class="btn btn-secondary">この学生に推薦を送る</button>
</form>



</article>
