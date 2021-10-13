<?php 

require_once('db_inc.php');
require_once('data.php');
$rec_id = $_GET['rec_id'];
$sql = <<<EOM
SELECT * FROM tb_recruitment 
NATURAL JOIN tb_timetable 
NATURAL JOIN tb_teacher 
NATURAL JOIN tb_subject
NATURAL JOIN tb_role 
WHERE rec_id = '{$rec_id}'
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
// echo $rec_id;

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
      </tbody>
    </table>
  </div>

  <hr color="#000000" width="80%" size="3">

  <h1>TA・SA 募集要項</h1>
    <div class="application-form">
      <table class="table table-borderless">
        <thead>
          <tr>
            <th scope="col" width="15%"></th>
            <td scope="col"></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">募集役割</th>
            <td><?= $row['role_kind']; ?></td>
          </tr>
          <tr>
            <th scope="row">募集人数</th>
            <td ><?= $row['rec_num']; ?>&nbsp;人</td>
          </tr>
          <tr>
            <th scope="row">教員コメント</th>
            <td><?= $row['rec_comment']; ?></td>
          </tr>
        </tbody>
      </table>
      <hr color="#000000" width="80%" size="3">

      <form action="?do=student_application_add" method="post">
      <div class="form-group">
          <!-- hiddenで(rec_id)を送るのはセキュリティ上どうなのだろうか？--ページのソース参照からばれてしまう。 -->
          <?php 
          echo '<input type="hidden" class="form-control" name="rec_id" value="'.$rec_id.'">'
           ?>
      </div>
      <div class="form-group">
          <label for="app-comment">意気込み・連絡事項</label>
          <textarea class="form-control" id="app-comment" name='app_comment' rows="4"></textarea>
      </div>
      
      <button type="submit" class="btn btn-primary">応募する</button>
    </form>   
    </div>     
</div>
