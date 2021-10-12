<!DOCTYPE html> 
<html lang="ja"><head>
<meta http-equiv="Content-TYPE" content="text/html; charset=UTF-8">

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" TYPE="text/css" href="css/style.css">

<!-- Vue -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<!-- import axios -->
<script src="https://cdn.jsdelivr.net/npm/axios@0.18.0/dist/axios.min.js"></script>

</head>
<body>
<div class="wrapper">

  <nav class="navbar navbar-dark bg-dark">
  <!-- Navbar content -->
  <a href="?do=pb_home"><h5 class="text-white h4">TA・SA募集管理システム</h5></a>

<?php

echo '<div class="right-content">';
  
if (isset($_SESSION['usr_kind'])){
  echo '<p class="text-white" style="display:inline">';
  echo $_SESSION['usr_name'].'&nbsp;&nbsp;</p>';
  if($_SESSION['usr_kind'] == 1){ //学生
    $menu = array(   //メニュー項目：プログラム名（拡張子.php省略）
      'HOME'  => 'student_home',
      'スケジュール管理' => 'student_schedule',
      'アンケート回答' => 'student_answer'
    );
  }  
  
  if($_SESSION['usr_kind'] == 2){ //教員

    $menu = array(   //メニュー項目：プログラム名（拡張子.php省略）
      'HOME'  => 'teacher_home',
    );
  }  

  if($_SESSION['usr_kind'] == 9){ //管理者
    $menu = array(   //メニュー項目：プログラム名（拡張子.php省略）
      'HOME'  => 'admin_home',
    );
  }

  foreach($menu as $label=>$action){ 
    echo  '<a href="?do=' . $action . '">' . $label . '</a>&nbsp&nbsp;' ;
  }
  echo  '<a href="?do=sys_logout"><button type="button" class="btn btn-secondary btn-sm">ログアウト</button></a>&nbsp;' ;
  }else{
   echo  '<a href="?do=sys_login"><button type="button" class="btn btn-primary btn-sm">ログイン</button></a>' ;
  }

?>
</div>
  </nav>

