<?php 
require_once('db_inc.php');
require_once('data.php');


// select * from tb_student stu natural join tb_course natural join tb_subject where sub_name like '%プログラミング%' and stu_id = '30RS001';

$rcmflg = false;
$rec_id = $_POST['rec_id'];
$search = '';
$stu_id = $_GET['stu_id'];
if(isset($_GET['app_id'])){
  $app_id = $_GET['app_id'];
}
if(isset($_POST['search'])) {
    $search = $_POST["search"];
}

//募集科目の詳細を取得
$sql = <<<EOM
SELECT * FROM tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_teacher NATURAL JOIN tb_subject
WHERE rec_id = '{$rec_id}' AND rec.tt_id = tt.tt_id
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$subject_detail = [
  'sub_name' => $row['sub_name'],
  'tea_name' => $row['tea_name'],
  'semester' => $row['semester'],
  'tt_weekday' => $row['tt_weekday'],
  'tt_timed' => $row['tt_timed'],
  'role_id' => $row['role_id'],
  'rec_num' => $row['rec_num'],
  'rec_comment' => $row['rec_comment']
];

//応募学生の詳細を取得
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
if(isset($app_id)){
  $sql = <<<EOM
  SELECT * FROM tb_application WHERE app_id = '{$app_id}'
  EOM;
  $rs = $conn->query($sql);
  $row = $rs->fetch_assoc();
  $stu_detail['app_comment'] = $row['app_comment'];
}

//推薦者であったときは処理方法を変える。
if(isset($_GET['rcm_id'])){
  $rcm_id = $_GET['rcm_id'];
  $rcmflg = true;
  $sql = <<<EOM
  SELECT * FROM tb_recommend rcm,tb_student stu
  WHERE rcm.stu_id = stu.stu_id AND rcm.rcm_id = '{$rcm_id}'
  EOM;
  $rs = $conn->query($sql);
  $row = $rs->fetch_assoc();
}

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
            <td><?= $subject_detail['sub_name']; ?></td>
          </tr>
          <tr>
            <th scope="row" class="table-secondary">担当教員</th>
            <td><?= $subject_detail['tea_name']; ?></td>
          </tr>
          <tr>
            <th scope="row" class="table-secondary">学期</th>
            <td><?= $semesters[$subject_detail['semester']];?></td>
          </tr>
          <tr>
            <th scope="row" class="table-secondary">曜日</th>
            <td><?= $weekdays[$subject_detail['tt_weekday']]; ?></td>
          </tr>
          <tr>
            <th scope="row" class="table-secondary">時限</th>
            <td><?= $times[$subject_detail['tt_timed']]; ?></td>
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
            <td><?= $role[$subject_detail['role_id']]; ?></td>
          </tr>
          <tr>
            <th scope="row" class="table-secondary">募集人数</th>
            <td><?= $subject_detail['rec_num']; ?>人</td>
          </tr>
          <tr>
            <th scope="row" class="table-secondary">教員コメント</th>
            <td style="white-space:pre-wrap;"><?= $subject_detail['rec_comment']; ?></td>
          </tr>
        </tbody>
      </table>
  </div>
</div>

<hr style="border:0;border-top:1px solid black;">


<div >
   <div>
       <h2>学生の情報</h2>
   </div>
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
</div>
<?php  
if(isset($stu_detail['app_comment'])){
echo '<table class="table table-borderless"><tbody><tr>';
echo '<th scope="row" width="15%">学生コメント</th>';
echo '<td>'.$stu_detail['app_comment'].'</td>';
echo '</tr></tbody></table>';  
}
?>


<hr style="border:0;border-top:1px solid black;">

<!-- 学生と教員のアンケート情報を取得して表形式で表示する。 -->
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
?>




<!-- 以下検索フォーム -->

<?php 
if(isset($app_id)){
  echo '<form action="?do=teacher_application_detail&stu_id='.$stu_id.'&app_id='.$app_id.'" method="post" class="form-inline">';
}

if(isset($rcm_id)){
  echo '<form action="?do=teacher_application_detail&stu_id='.$stu_id.'&rcm_id='.$rcm_id.'" method="post" class="form-inline">';
}

echo   '<div class="form-group">';
echo     '<label for="input_sub" class="col-sm-4 col-form-label">科目別成績</label>';
echo     '<div class="col-sm-7">';
echo       '<input type="text" class="form-control" id="input-sub" name="search" value="'.$search.'">';
echo     '</div>';
echo   '</div>';
echo   '<input type="hidden" name="rec_id" value="'.$rec_id.'">';
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



<?php 
if(isset($app_id)){
  $sql = <<<EOM
  SELECT * FROM tb_application WHERE app_id = '{$app_id}'
  EOM;
  $rs = $conn->query($sql);
  $row = $rs->fetch_assoc();
  if($row['app_result'] === NULL){


?>
<!-- modalで確認を取る場合 -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
  採用決定
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        この学生を本当に採用決定しますか?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
        <?php 
        echo '<a class="btn btn-primary" href="?do=teacher_application_save&app_id='.$app_id.'&rec_id='.$rec_id.'" role="button">決定</a>'
          ?>
      </div>
    </div>
  </div>
</div>


<?php 
  }
}
 ?>
<div style="text-align: right;">
  
<a class="btn btn-primary" href="?do=teacher_application_list&rec_id=<?= $rec_id;?>" role="button">応募・推薦者リストに戻る</a>
</div>

