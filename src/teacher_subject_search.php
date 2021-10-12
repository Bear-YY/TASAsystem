<?php 
if($_POST){
	$sub_name = $_POST['sub_name'];
}else{
	$sub_name = NULL;
}
$stu_id = $_GET['stu_id'];
?>

<?php 
echo '<form action="?do=teacher_subject_search&stu_id='.$stu_id.'" method="post" class="form-inline">';
echo   '<div class="form-group">';
echo     '<label for="input_sub" class="col-sm-4 col-form-label">科目別成績</label>';
echo     '<div class="col-sm-7">';
echo       '<input type="text" class="form-control" id="input-sub" name="sub_name" value="'.$sub_name.'">';
echo     '</div>';
echo   '</div>';
echo   '<button type="submit" class="btn btn-primary mb-0">検索</button>';
echo '</form>';
?>
            
<!-- $sql = "SELECT * FROM user_list WHERE ID='".$_POST["id"] ."' OR Name LIKE  '%".$_POST["user_name"]."%')" -->
 
