<?php 
require_once('db_inc.php');
require_once('data.php');
$ttid = $_GET['tt_id'];
$tid = $_SESSION['usr_id'];
$act = "insert";

$sql = "select * from tb_recruitment where tt_id = '{$ttid}'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
if($row){
  $act = 'update';
  $rec_id = $row['rec_id'];
  $rec_comment = $row['rec_comment'];
}




$sql = <<<EOM
SELECT * FROM tb_timetable NATURAL JOIN tb_teacher NATURAL JOIN tb_subject NATURAL JOIN tb_category
WHERE tea_id = '{$tid}' AND tt_id = '{$ttid}'
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();

// echo $ttid;
// echo $tid;
 ?>
<div class="main">
    <h1>時間割詳細</h1>
  <div class="tablearea-sm">
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
          <th scope="row" class="table-secondary">カテゴリー</th>
          <td><?= $row['category_name']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>

  <hr color="#000000" width="80%" size="3">

  <h1>TA・SA 募集要項</h1>
    <div class="recruit-form">
<!--        デバック用に切り替えて(上のほうがデバック用)-->      
<?php 
if($act === 'insert'){
  echo '<form action="?do=teacher_recruitment_save&tt_id='.$ttid.'&act='.$act.'" method="post"';
}
if($act === 'update'){
  echo '<form action="?do=teacher_recruitment_save&rec_id='.$rec_id.'&act='.$act.'&tt_id='.$ttid.'" method="post"';
}
echo ' class="needs-validation" novalidate>';
 ?>
        <!-- <form action="?do=eps_subject" method="post"> -->
      <div class="form-group row">
        <label for="sub_name-form" class="col-sm-2 col-form-label">募集人数</label>
        <div>
          <input type="text" class="form-control" name="rec_num" id="rec-num-form" placeholder="例:2" required>
          <div class="invalid-feedback">
            募集人数を記入してください。
          </div>
        </div>
        
      </div>
      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">募集役割</legend>
          <div class="col-sm-0">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="role_id" id="role-id-form1" value="1" required>
              <label class="form-check-label" for="role-id-form1">SA</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="role_id" id="role-id-form2" value="2" required>
              <label class="form-check-label" for="role-id-form2">TA</label>
            </div>
          </div>
        </div>
      </fieldset>

      <div class="form-group">

          <label for="rec-comment">教員コメント</label>
          <?php 
            if(isset($rec_comment)){
          ?>
              <table >
                <tbody>
                  <tr>
                    <td width="200px">※前回設定したコメント</td>
                    <td><?= $rec_comment ;?></td>
                  </tr>
                </tbody>
              </table>
          <?php 
            }
          ?>
          <textarea class="form-control" id="rec-comment" name='rec_comment' rows="4" required></textarea>
          <div class="invalid-feedback">
            募集するに当たってのコメント、連絡事項等を記入してください。
          </div>
      </div>
      <hr color="#000000" width="80%" size="3">

<?php 
$sql = "SELECT * FROM tb_questionnaire";
if($act === 'update'){
  $sql = "SELECT * FROM tb_questionnaire NATURAL JOIN tb_config WHERE tt_id = '{$ttid}'";
}
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();

echo '<h1>応募者に求める資質</h1>';
 
while($row):
  echo '<h5>・'.$row['que_title'];
  if($act === 'update'){
    echo '&nbsp&nbspーー前回の回答：'.$ques[$row['con_value']].'</h5>';
  }
  echo '</h5>';

  echo '<div class="radio-area">';
  for($i = 0; $i <= 5; $i++):
    echo '<div class="form-check">';
    echo '<input class="form-check-input" type="radio" value="'.$i.'" id="Check1" name="'.$row['que_id'].'"';
    if($i === 0){
      echo 'checked';
    }
    echo '>';
?>
  <label class="form-check-label" for="Check1">

<?php 
switch ($i) {
  case 1:
      echo "当てはまる";// code...
    break;
  case 2:
      echo "やや当てはまる";// code...
    // code...
    break;
  case 3:
      echo "どちらでもない";// code...
    // code...
    break;
  case 4:
      echo "やや当てはまらない";// code...
    // code...
    break;
  case 5:
      echo "当てはまらない";// code...
    // code...
    break;
  default:
    echo '特になし';// code...
    break;
}
?>
  </label>
  </div>
<?php 
  endfor;
  $row = $rs->fetch_assoc();
  echo "</div>";
  echo "<br>";
  endwhile
;?>
      <hr color="#000000" width="80%" size="3">
      <button type="submit" class="btn btn-primary">
      <?php 
      if($act === 'insert'){
        echo '登録';
      }
      if($act === 'update'){
        echo '更新';
      }
      ?>
      </button>
    </form>   
    </div>     
</div>

<script src="../js/validation.js"></script>
