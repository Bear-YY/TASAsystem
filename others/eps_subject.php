<p>こんにちは</p>
<?php

$subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
$dou = htmlspecialchars($_POST['dou'], ENT_QUOTES, 'UTF-8');
$nou = htmlspecialchars($_POST['nou'], ENT_QUOTES, 'UTF-8');
$grade = htmlspecialchars($_POST['grade'], ENT_QUOTES, 'UTF-8');
$subclass = htmlspecialchars($_POST['subclass'], ENT_QUOTES, 'UTF-8');

$see = 1;

$array = array(
	"subjet" => $subject,
	"dou" => $dou, 
	"nou" => $nou, 
	"grade" => $grade,
	"subclass" => $subclass 
);

$json = json_encode($array);
$bytes = file_put_contents("myfile.json", $json);
// デバッグ用にダンプ
var_dump($array);

echo json_encode( "送信が完了しました！" );

?>
