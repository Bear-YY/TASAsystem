<?php
  require_once('db_inc.php'); //データベースが必要なので読み込ませる
  $u = $_POST['usr_id'] ;  
  $p = $_POST['passwd'];  
  $sql = "SELECT * FROM tb_user WHERE usr_id= '{$u}' AND passwd='{$p}'";
  $rs = $conn->query($sql);
  if (!$rs) die('エラー: ' . $conn->error);
  $row= $rs->fetch_assoc();
  if ($row){ //Login succeeded
    $_SESSION['usr_id']   = $row['usr_id'];
    $_SESSION['usr_name'] = $row['usr_name'];
    $_SESSION['usr_kind'] = $row['usr_kind'];
    header('Location:index.php');   
  }else{
    header('Location:?do=sys_login');   
  }
?>