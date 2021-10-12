<?php
session_start();
include('src/pg_header.php');
$action = 'pb_home';
if (isset($_GET['do'])) {
  $action = $_GET['do'];
}
include('src/' . $action . '.php');
include('src/pg_footer.php');