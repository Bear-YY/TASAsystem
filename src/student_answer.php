<h1>アンケート回答</h1>
<?php 
require_once('db_inc.php');
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
  endwhile;
  ?>
      <button type="submit" class="btn btn-primary">登録</button>
    </form>   
  </div>
</article>