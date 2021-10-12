<?php 
require_once('db_inc.php');

$sql = <<< EOM
SELECT testID,testNO
FROM test
ORDER BY testID
EOM;

$e = 0;

$rs = $conn->query($sql);

$row = $rs -> fetch_assoc();
while($row){
	echo "testID:".$row['testID'];
	echo "testNO:".$row['testNO'];
	echo "<br>";
  	$row = $rs -> fetch_assoc();
}

 ?>