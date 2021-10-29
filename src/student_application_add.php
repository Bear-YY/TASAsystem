<?php 
require_once('db_inc.php');
$usr_id = $_SESSION['usr_id'];
$stu_id = strtoupper($usr_id); //全部大文字
$stu_id = mb_substr($stu_id, 1);  //頭の一文字を消す(細かい使い方は調べましょう)
$act = $_GET['act'];

$date = strtotime("+12 year", time());   //日付を取得(12年後を取得)
$app_day = date('Y-m-d', $date);		 //表示形式を'Y-m-d'(year-month-day)にする

// echo $stu_id;
// echo $rec_id;   //日付を取得(12年後を取得)
// echo $app_day;		 //表示形式を'Y-m-d'(year-month-day)にする
// echo $app_comment;
echo $act;
if($act == 'insert'){    
    $app_comment = $_POST['app_comment'];
    $rec_id = $_POST['rec_id'];
    $sql = <<<EOM
    INSERT INTO tb_application(stu_id,rec_id,app_day,app_comment) 
    VALUES('{$stu_id}','{$rec_id}','{$app_day}','{$app_comment}')
    EOM;
}
if($act == 'update'){
    $app_cancmnt = $_POST['app_cancmnt'];
    $app_id = $_POST['app_id'];
    echo $app_cancmnt; echo '<br>';
    echo $app_id; echo '<br>';    

    $sql = "UPDATE tb_application SET app_cancmnt = '{$app_cancmnt}', app_result = '3' WHERE app_id = '{$app_id}'";
}

$rs = $conn->query($sql);
$url = '?do=student_home';
header('Location:'.$url);
?>