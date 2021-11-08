<?php
require_once('db_inc.php');
require_once('data.php');
$tt_id = $_GET['tt_id'];
$tea_id = $_SESSION['usr_id'];
$act = "insert";

//募集している時は募集情報を取得(募集しているなら検索結果があるから、あるときと無いときで処理を変える)
$sql = "select * from tb_recruitment where tt_id = '{$tt_id}'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$prevrec = [];

//募集している科目があったときの処理
if($row){
  $act = 'update';
  $rec_id = $row['rec_id'];
  $prevrec = [
    'rec_comment' => $row['rec_comment'],
    'role_id' => $row['role_id'],
    'rec_num' => $row['rec_num']
  ];
  //前回のアンケート設定値を取得
  $sql = "SELECT * FROM tb_config WHERE tt_id = '{$tt_id}' ORDER BY que_id";
  $rs = $conn->query($sql);
  $row = $rs->fetch_assoc();
  $configs = [];
  while($row){
    $que_id = $row['que_id'];
    $configs[$que_id] = $row['con_value'];
    $row = $rs->fetch_assoc();
  }
  var_dump($prevrec);
}
//

$sql = <<<EOM
SELECT * FROM tb_timetable NATURAL JOIN tb_teacher NATURAL JOIN tb_subject NATURAL JOIN tb_category
WHERE tea_id = '{$tea_id}' AND tt_id = '{$tt_id}'
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();

// echo $tt_id;
// echo $tea_id;
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
  echo '<form action="?do=teacher_recruitment_save&tt_id='.$tt_id.'&act='.$act.'" method="post"';
}
if($act === 'update'){
  echo '<form action="?do=teacher_recruitment_save&rec_id='.$rec_id.'&act='.$act.'&tt_id='.$tt_id.'" method="post"';
}
echo ' class="needs-validation" novalidate>';
?>
        <!-- <form action="?do=eps_subject" method="post"> -->
      <div class="form-group row">
        <label for="sub_name-form" class="col-sm-2 col-form-label">募集人数</label>
        <div>
          <input type="text" class="form-control" name="rec_num" id="rec-num-form" placeholder="例:2"
<?php if($act === 'update'): ?>
          value="<?= $prevrec['rec_num'];?>"
<?php endif; ?>
          required>
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
              <input class="form-check-input" type="radio" name="role_id" id="role-id-form1" value="1"
<?php if($act === 'update'):
        if($prevrec['role_id'] == 1):
?>
          checked
<?php   endif; ?>
<?php endif; ?>
              required>
              <label class="form-check-label" for="role-id-form1">SA</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="role_id" id="role-id-form2" value="2"
<?php if($act === 'update'):
        if($prevrec['role_id'] == 2):
?>
          checked
<?php   endif; ?>
<?php endif; ?>
              required>
              <label class="form-check-label" for="role-id-form2">TA</label>
            </div>
          </div>
        </div>
      </fieldset>

      <div class="form-group">

          <label for="rec-comment">教員コメント</label>
          <textarea class="form-control" id="rec-comment" name='rec_comment' rows="4" required>
<?php if($act === 'update'){
          echo $prevrec['rec_comment'];
      }
?></textarea>
          <div class="invalid-feedback">
            募集するに当たってのコメント、連絡事項等を記入してください。
          </div>
      </div>
      <hr color="#000000" width="80%" size="3">

<?php
$sql = "SELECT * FROM tb_questionnaire";
$state = false;

if($act === 'update'){
  $sql = "SELECT * FROM tb_questionnaire NATURAL JOIN tb_config WHERE tt_id = '{$tt_id}'";
}
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
if($row){
  $state = true;
}

echo '<h1>この時間割における応募者に求める資質</h1>';

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
    if($act == 'update'){
      if($i == $configs[$row['que_id']]){
        echo 'checked';
      }
    }else{
      if($i == 0){
        echo 'checked';
      }
    }
    echo '>';
?>
  <label class="form-check-label" for="Check1">
<?php
echo $ques[$i];

?>
  </label>
  </div>
<?php
  endfor;
  $row = $rs->fetch_assoc();
  echo "</div>";
  echo "<br>";
  endwhile;
  ?>
      <hr color="#000000" width="80%" size="3">
      <?php
      if($act === 'insert'){
        if($state){
          echo '<button type="submit" class="btn btn-primary">';
          echo '登録';
        }
      }
      if($act === 'update'){
        echo '<button type="submit" class="btn btn-primary">';
        echo '更新';
      }
      ?>
      </button>
    </form>
    </div>
</div>

<script src="../js/validation.js"></script>
