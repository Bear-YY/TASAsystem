<?php 
require_once('db_inc.php');
$role_id = $_POST['role_id'];
$tea_id = $_SESSION['usr_id'];
$rec_comment = $_POST['rec_comment'];
$rec_num = $_POST['rec_num'];

$act = $_GET['act'];
echo $act;
// 本システムでは学生情報などが2033年のものであると仮定している。
$date = strtotime("+12 year", time());
$date = date('Y-m-d', $date);
$ques = array_slice($_POST, 3, NULL, TRUE );
echo $date;
//var_dump($ques);

if($act === 'update'){
    $rec_id = $_GET['rec_id'];
    $tt_id = $_GET['tt_id'];
    // echo 'rec_id:'.$rec_id;
    $sql = <<<EOM
    UPDATE tb_recruitment SET role_id = '{$role_id}' ,rec_comment = '{$rec_comment}',
    rec_num = '{$rec_num}', rec_day = '{$date}' WHERE rec_id = '{$rec_id}'
    EOM;
    $rs = $conn->query($sql);
    if (!$rs) die('エラー: ' . $conn->error);
    foreach ($ques as $key => $value) {
        $sql ="UPDATE tb_config SET con_value = '{$value}' WHERE tt_id = '{$tt_id}' AND que_id = '{$key}'";
        $rs = $conn->query($sql);
        if (!$rs) die('エラー: ' . $conn->error);
    }

}


if($act === 'insert'){  
    $tt_id = $_GET['tt_id'];  
    // echo 'tt_id:'.$tt_id;
    $sql = <<<EOM
    INSERT INTO tb_recruitment(tt_id,role_id,tea_id,rec_day,rec_comment,rec_num)
    VALUES('{$tt_id}','{$role_id}','{$tea_id}','{$date}','{$rec_comment}','{$rec_num}')
    EOM;
    $rs = $conn->query($sql);
    
    foreach ($ques as $key => $value) {
        $sql ="INSERT INTO tb_config(tt_id,que_id,con_value)
            VALUES('{$tt_id}','{$key}','{$value}')";
        $rs = $conn->query($sql);
        if (!$rs) die('エラー: ' . $conn->error);
    }
}
$url = '?do=teacher_home';
header('Location:'.$url);


 ?>