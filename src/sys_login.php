<div align="center" class="login">
<?php 
if(isset($_GET['err'])){
  $err = $_GET['err'];
  if($err === 'wrong'){
    echo '<p class="red">ログインIDまたはパスワードが間違っています</p>';
    echo '<p class="red">入力をやり直してください</p>';
  }
}
 ?>


<form action="?do=sys_check" method="post" class="needs-validation" novalidate>
  <div class="login-form">
    <div class="form-group" style="width: 50%;">
      <label for="uid-form">ユーザーID</label>
      <input type="text" class="form-control" name="usr_id" id="uid-form" placeholder="ユーザーIDを入力してください" required>
      <div class="invalid-feedback">
        ユーザーIDを入力してください。
      </div>
    </div>
    <div class="form-group" style="width: 50%;">
      <label for="pass-form">パスワード</label>
      <input type="password" class="form-control" id="" name="passwd" placeholder="パスワードを入力してください" required>
      <div class="invalid-feedback">
        パスワードを入力してください。
      </div>
    </div>
    <button type="submit" class="btn btn-primary">ログイン</button>&nbsp;
    <button type="reset" class="btn btn-secondary">取消</button>
</div>

</form>
</div>

<!--  -->
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
  }
 ?>

<script src="../js/validation.js"></script>

