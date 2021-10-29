<?php 
require_once('db_inc.php');
require_once('data.php');

$search = '';
if(isset($_POST["search"])) {
    $search = $_POST["search"];
}

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
<hr style="border:0;border-top:1px solid black;">

<h3>成績要件を満たす学生</h3>
<table class="table table-sm table-bordered">
	<thead class="thead-dark"> 
		<tr>
    	  <th scope="col">学籍番号</th>
    	  <th scope="col">氏名</th>
    	  <th scope="col">学年</th>
    	  <th scope="col">GPA</th>
    	  <th scope="col">成績</th>
    	  <th scope="col">メールアドレス</th>
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
      </tr>
    </tbody>
</table>


<hr style="border:0;border-top:1px solid black;">
<?php 
//学生のアンケート回答情報を取得
$sql = "SELECT * FROM tb_questionnaire NATURAL JOIN tb_answer WHERE stu_id = '{$stu_id}'";
$rs = $conn->query($sql);
if(!$rs) die('エラー: '. $conn->error);
$row = $rs->fetch_assoc();
$ansinfo = [];
while($row){
  $que_id = $row['que_id'];
  $ansinfo[$que_id] = [
    'que_title' => $row['que_title'],
    'ans_value' => $row['ans_value'] 
  ];
  $row = $rs->fetch_assoc();
}

//教員のアンケート設定情報を取得
$sql = "SELECT * FROM tb_config NATURAL JOIN tb_questionnaire NATURAL JOIN tb_recruitment WHERE rec_id = '{$rec_id}'";
$rs = $conn->query($sql);
if(!$rs) die('エラー: '. $conn->error);
$row = $rs->fetch_assoc();
$coninfo = [];
while($row){
  $que_id = $row['que_id'];
  $coninfo[$que_id] = [
    'con_value' => $row['con_value'] 
  ];
  $row = $rs->fetch_assoc();
}

if($ansinfo){

?>

<h3>アンケート回答結果</h3>
<table class="table table-sm table-bordered">
  <thead class="thead-dark"> 
    <tr>
        <th scope="col">アンケート項目名</th>
        <th scope="col">学生回答</th>
        <th scope="col">教員設定</th>
      </tr>
  </thead>  
    <tbody>
      <?php 
      foreach ($ansinfo as $key => $value) {
       ?>
      <tr>
        <td><?= $value['que_title']; ?></td>
        <td><?= $ques[$value['ans_value']]; ?></td>
        <td><?= $ques[$coninfo[$key]['con_value']]; ?></td>
      </tr>
      <?php 
      }
      ?>

    </tbody>
</table>
<hr style="border:0;border-top:1px solid black;">

<?php
}
echo '<form action="?do=teacher_recommend_detail&stu_id='.$stu_id.'&rec_id='.$rec_id.'" method="post" class="form-inline">';
echo   '<div class="form-group">';
echo     '<label for="input_sub" class="col-sm-4 col-form-label">科目別成績</label>';
echo     '<div class="col-sm-7">';
echo       '<input type="text" class="form-control" id="input-sub" name="search" value="'.$search.'">';
echo     '</div>';
echo   '</div>';
echo   '<button type="submit" class="btn btn-primary mb-0">検索</button>';
echo '</form>';


if($search === ''){
  $sql = <<<EOM
  SELECT * FROM tb_student stu NATURAL JOIN tb_course NATURAL JOIN tb_subject WHERE stu_id = '{$stu_id}'
  EOM;
}else{
  $sql = <<<EOM
  SELECT * FROM tb_student stu NATURAL JOIN tb_course NATURAL JOIN tb_subject WHERE sub_name LIKE '%$search%' AND stu_id = '{$stu_id}'
  EOM;
}
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$subjects = [];
while($row){
  $sub_id = $row['sub_id'];
  $subjects[$sub_id] = [
    'sub_name' => $row['sub_name'],
    'grade' => $row['grade'],
    'get_year' => $row['get_year']
  ];
  $row = $rs->fetch_assoc();
}
if($subjects):
?>


<div class="tablearea-sm">
  <table class="table table-sm table-bordered">
    <thead class="thead-dark"> 
      <tr>
          <th scope="col">科目名</th>
          <th scope="col">成績</th>
          <th scope="col">取得学年</th>
        </tr>
    </thead>  
      <tbody>
        <?php foreach ($subjects as $key => $value): ?>
          
        <tr>
          <td><?= $value['sub_name']; ?></td>
          <td><?= $grade[$value['grade']]; ?></td>
          <td><?= $value['get_year']; ?>年生</td>
          </td>
        </tr>
        
        <?php endforeach ?>
      </tbody>
  </table>
</div>
<?php 
else:
  echo '<p>その科目をこの学生は履修していません。</p>';
endif;


 ?>

<form action="?do=teacher_recommend_add" method="post">
<input type="hidden" name="rec_id" value="<?= $rec_id;?>">	
<input type="hidden" name="stu_id" value="<?= $stu_id;?>">	
<input type="hidden" name="tea_id" value="<?= $tea_id;?>">	
<input type="hidden" name="stu_name" value="<?= $stu_detail['stu_name'];?>">	
<input type="hidden" name="ad_year" value="<?= $stu_detail['ad_year'];?>">	
<button type="submit" class="btn btn-secondary">この学生に推薦を送る</button>
</form>



</article>
