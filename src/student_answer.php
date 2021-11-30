<h1>アンケート回答</h1>
<?php
require_once('db_inc.php');
require_once('data.php');
$usr_id = $_SESSION['usr_id'];
$stu_id = strtoupper($usr_id); //全部大文字
$stu_id = mb_substr($stu_id, 1);  //頭の一文字を消す(細かい使い方は調べましょう)
$act = 'insert';

$sql = "SELECT * FROM tb_answer WHERE stu_id = '{$stu_id}'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();

if($row){
  $act = 'update';
  $answers = [];
  while($row){
    $que_id = $row['que_id'];
    $answers[$que_id] = $row['ans_value'];
    $row = $rs->fetch_assoc();
  }
}

// var_dump($answers);

// var_dump($act);

$sql = "SELECT * FROM tb_questionnaire";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$questions = [];
while($row){
  $que_id = $row['que_id'];
  $questions[$que_id] = [
    'que_title' => $row['que_title'],
  ];
  $row = $rs->fetch_assoc();
}
?>

<article>
  <div class="main">
<?php

echo '<form action="?do=student_answer_save&act='.$act.'" method="post">';

foreach ($questions as $key => $value) :
  // code...
  echo '<h5>・'.$value['que_title'].'</h5>';
  echo '<div class="radio-area">';
  for($i = 1; $i <= 5; $i++):
    echo '<div class="form-check">';
    echo '<input class="form-check-input" type="radio" value="'.$i.'" id="Check1" name="'.$key.'"';
    if($act == 'update'){
      if($i == $answers[$key]){
        echo 'checked';
      }
    }else{
      if($i == 1){
        echo 'checked';
      }
    }
    echo '>';
?>
  <label class="form-check-label" for="Check1">
<?php echo $ques[$i]; ?>

  </label>
  </div>
<?php
  endfor;
  $row = $rs->fetch_assoc();
  echo "</div>";
  echo "<br>";
endforeach;
  if($act === 'insert'){
    if($questions){
      echo '<button type="submit" class="btn btn-primary">登録</button>';
    }
  }
  if($act === 'update')
      echo '<button type="submit" class="btn btn-primary">更新</button>';
  ?>
    </form>
  </div>
</article>
