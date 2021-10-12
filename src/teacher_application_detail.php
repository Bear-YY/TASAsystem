<?php 
require_once('db_inc.php');
require_once('data.php');
$rcmflg = false;
if(isset($_POST['rec_id'])){
  $rec_id = $_POST['rec_id'];
}

if(isset($_GET['app_id'])){
  $app_id = $_GET['app_id'];
  $sql = <<<EOM
  SELECT * FROM tb_application app NATURAL JOIN tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_subject sub,tb_course cou,tb_student stu
  WHERE app_id = '{$app_id}' AND rec.tt_id = tt.tt_id AND cou.sub_id = sub.sub_id AND app.stu_id = cou.stu_id AND app.stu_id = stu.stu_id
  EOM;
  $rs = $conn->query($sql);
  $row = $rs->fetch_assoc();
}


if(isset($_GET['rcm_id'])){
  $rcm_id = $_GET['rcm_id'];
  $rcmflg = true;
  $sql = <<<EOM
  SELECT * FROM tb_recommend rcm,tb_student stu NATURAL JOIN tb_recruitment rec
  WHERE rcm.stu_id = stu.stu_id AND rec.rec_id = '{$rec_id}'
  EOM;
  $rs = $conn->query($sql);
  $row = $rs->fetch_assoc();
}

$sub_name = $_POST['sub_name'];
$tea_name = $_POST['tea_name'];
$semester = $_POST['semester'];
$tt_weekday = $_POST['tt_weekday'];
$tt_timed = $_POST['tt_timed'];
$role_id = $_POST['role_id'];
$rec_num = $_POST['rec_num'];



 ?>

<div class="tablearea-sm">
   <div>
       <h2>募集時間割</h2>
   </div>
   <table class="table table-sm table-bordered">
     <tbody>
       <tr>
         <th scope="row" width="25%" class="table-secondary">科目名</th>
         <td><?= $sub_name; ?></td>
       </tr>
       <tr>
         <th scope="row" class="table-secondary">担当教員</th>
         <td><?= $tea_name; ?></td>
       </tr>
      <tr>
         <th scope="row" class="table-secondary">学期</th>
         <td><?= $semesters[$semester];?></td>
       </tr>
       <tr>
         <th scope="row" class="table-secondary">曜日</th>
         <td><?= $weekdays[$tt_weekday]; ?></td>
       </tr>
       <tr>
         <th scope="row" class="table-secondary">時限</th>
         <td><?= $times[$tt_timed]; ?></td>
       </tr>
       <tr>
         <th scope="row" class="table-secondary">募集役割</th>
         <td><?= $role[$role_id]; ?></td>
       </tr>
       <tr>
         <th scope="row" class="table-secondary">募集人数</th>
         <td><?= $rec_num; ?>人</td>
       </tr>
     </tbody>
   </table>
</div>

<hr style="border:0;border-top:1px solid black;">


<div >
   <div>
       <h2>募集学生の応募情報</h2>
   </div>
   <table class="table table-bordered">
     <thead>
         <th scope="row"  class="table-secondary">学籍番号</th>
         <th scope="row" class="table-secondary">氏名</th>
         <th scope="row" class="table-secondary">学年</th>
         <th scope="row" class="table-secondary">成績</th>
         <th scope="row" class="table-secondary">メールアドレス</th>
         <th scope="row" class="table-secondary">操作</th>


     </thead>
     <tbody>
       <tr>
         <td><?= $row['stu_id']; ?></td>
         <td><?= $row['stu_name']; ?></td>
         <?php  
            $stu_year = $fake_year - $row['ad_year'];
         ?>
         <td><?= $school_grade[$stu_year];?></td>
         <td><?= $grade[$row['grade']]; ?></td>
         <?php 
            //$usr_mail:学籍番号を使用した場合のメールアドレス
            $usr_mail = mb_strtolower($row['stu_id']);
            $usr_mail = 'k'.$usr_mail.'@kyusan.com';      
         ?>
         <!-- <td><?= $row['stu_mail'] ; ?></td>
          --><td><?= $usr_mail ; ?></td>
          <td align="center">
            <?php  
            echo '<a class="btn btn-danger btn-sm" href="?do=teacher_subject_search&stu_id='.$row['stu_id'].'" role="button" target="_brank">';
            ?>
              科目別の成績検索 <br> (別ウィンドウが開きます)
            </a>
          </td>
       <tr>
     </tbody>
   </table>
</div>

<?php 
if(!$rcmflg):
if($row['app_result'] === NULL):
?>
<!-- modalで確認を取る場合 -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
  採用決定
</button>

<!-- Modal -->
<?php  
?>
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
        echo '<a class="btn btn-primary" href="?do=teacher_application_save&app_id='.$app_id.'" role="button">決定</a>'
          ?>
      </div>
    </div>
  </div>
</div>

<?php 
endif;
endif;
 ?>

