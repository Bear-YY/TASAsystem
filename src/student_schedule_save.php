<?php 
require_once('db_inc.php');
$usr_id = $_SESSION['usr_id'];
$stu_id = strtoupper($usr_id); //全部大文字
$stu_id = mb_substr($stu_id, 1);  //頭の一文字を消す(細かい使い方は調べましょう)


if(isset($_POST['act'])){
    $act = $_POST['act'];

    if($act == 'delete'){
        $sch_id = $_POST['sch_id'];
        $sch_semester = $_POST['sch_semester'];
        $sql = <<<EOM
        DELETE FROM tb_schedule WHERE sch_id = '{$sch_id}';
        EOM;

    }
    
    if($act == 'insert'){
        $sch_name = $_POST['sch_name']; 
        $sch_weekday = $_POST['sch_weekday']; 
        $sch_timed = $_POST['sch_timed']; 
        $sch_detail = $_POST['sch_detail']; 
        $sch_semester = $_POST['sch_semester']; 
        $act = $_POST['act'];

        $sql = <<<EOM
        INSERT INTO tb_schedule(stu_id,sch_name,sch_weekday,sch_timed,sch_detail,sch_semester)
        VALUES('{$stu_id}','{$sch_name}','{$sch_weekday}','{$sch_timed}','{$sch_detail}','{$sch_semester}')
        EOM;

    }

    if($act == 'update'){

    }
    
    echo $act;
    $rs = $conn->query($sql);
    if(!$rs) die('エラー: '. $conn->error);
    $url = '?do=student_schedule&semester='.$sch_semester;
    header('Location:'.$url);

}


 ?>