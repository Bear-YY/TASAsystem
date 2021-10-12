<form action="?do=sys_check" method="post">
<!-- <table>
<tr><td>ユーザ名：</td><td><input type="text" name="uid"></td></tr>
<tr><td>パスワード：</td><td><input type="password" name="pass"></td></tr>
<tr><td></td><td>
  <input type="submit" value="送信">&nbsp;<input type="reset" value="取消">
</td></tr>
</table>
 -->
  <div class="login-form">
    <div class="form-group" style="width: 50%;">
      <label for="uid-form">ユーザーID：</label>
      <input type="text" class="form-control" name="usr_id" id="uid-form" placeholder="例:">
    </div>
    <div class="form-group" style="width: 50%;">
      <label for="pass-form">パスワード：</label>
      <input type="password" class="form-control" id="" name="passwd" placeholder="パスワードを入力してください。">
    </div>
  
    <button type="submit" class="btn btn-primary">ログイン</button>&nbsp;
    <button type="button" class="btn btn-secondary">取消</button>
<!-- 
    <a href="?do=admin_home"><h2>admin_home</h2></a>
    <a href="?do=student_home"><h2>student_home</h2></a>
    <a href="?do=teacher_home"><h2>teacher_home</h2></a>
 --> 
</div>

</form>