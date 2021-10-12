<h2>全体ホーム</h2>
<a href="?do=sys_home"></a>
<?php 
	if(isset($_SESSION['usr_kind'])){
		print("あなたはusr_kind:".$_SESSION['usr_kind']."でログインしています。");
		if($_SESSION['usr_kind'] == 1){
			header('Location:?do=student_home'); 
		}
		if($_SESSION['usr_kind'] == 2){
			header('Location:?do=teacher_home'); 
		}
		if($_SESSION['usr_kind'] == 9){
			header('Location:?do=admin_home'); 
		}
	}else{
		print("あなたはログインしていません。");
	}
 ?>