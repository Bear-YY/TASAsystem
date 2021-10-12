<?php 
  $conn = mysqli_connect("localhost","root","");//MySQLサーバへ接続
  mysqli_select_db($conn, "tasa2021");    // 使用するデータベースを指定
  mysqli_query($conn, 'set names utf8'); //文字コードをutf8に設定（文字化け対策）
?>