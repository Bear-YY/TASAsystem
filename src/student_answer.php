<h1>アンケート回答</h1>
<?php 
require_once('db_inc.php');
$usr_id = $_SESSION['usr_id'];
$stu_id = strtoupper($usr_id); //全部大文字
$stu_id = mb_substr($stu_id, 1);  //頭の一文字を消す(細かい使い方は調べましょう)
$act = 'insert';

$sql = "SELECT count() FROM tb_answer WHERE stu_id = '{$stu_id}')";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();


if($row > 0){
  $act = 'update';
}

var_dump($row);

$sql = "SELECT * FROM tb_questionnaire";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
?>

<article>
  <div class="main">
<?php 
echo '<form action="?do=student_answer_save" method="post">';
while($row):
  echo '<h5>・'.$row['que_title'].'</h5>';
  echo '<div class="radio-area">';
  for($i = 1; $i <= 5; $i++):
    echo '<div class="form-check">';
    echo '<input class="form-check-input" type="radio" value="'.$i.'" id="Check1" name="'.$row['que_id'].'"';
    if($i === 1){
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
}
?>
  </label>
  </div>
<?php 
  endfor;
  $row = $rs->fetch_assoc();
  echo "</div>";
  echo "<br>";
  endwhile;
  echo '<input type="hidden" name="act" value="<?= $act;?>">';
  if($act === 'insert'){
      echo '<button type="submit" class="btn btn-primary">登録</button>';
  }
  if($act === 'update')
      echo '<button type="submit" class="btn btn-primary">更新</button>';
  ?>
    </form>   
  </div>
</article>