<?php 
require_once('db_inc.php');
require_once('data.php');
$tea_id = $_SESSION['usr_id'];
$norec = array();
$rec = array();
//募集している時間割が存在するかをチェック
$sql = 
"SELECT EXISTS (SELECT * FROM tb_teacher NATURAL JOIN tb_recruitment WHERE tea_id = '{$tea_id}')";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();

//募集している時間割があるなら募集に関する情報を取得
if($row !== 0){


	/*$sql = 
	" SELECT rec.rec_id,tt.tt_id,rec.role_id,rec.rec_num,sub.sub_name,tt.tt_weekday,tt.tt_timed,rec.rec_id,semester
	FROM tb_teacher tea NATURAL JOIN tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_subject sub
	WHERE rec.tea_id = '{$tea_id}' AND rec.tt_id = tt.tt_id";*/
	
	$sql = 
	" SELECT * FROM tb_teacher tea NATURAL JOIN tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_subject sub
	WHERE rec.tea_id = '{$tea_id}' AND rec.tt_id = tt.tt_id";

	$rs = $conn->query($sql);
	$row = $rs->fetch_assoc();                    //募集してる時間割情報(それ以外の時間割は募集してない)
	while($row){
		array_push($rec, $row);
		$row= $rs->fetch_assoc();
	}
}

// $sql = "SELECT sub_name,semester,tt_weekday,tt_timed,tt_id FROM tb_teacher NATURAL JOIN tb_timetable NATURAL JOIN tb_subject WHERE tea_id = '{$tid}'";
// $rs = $conn->query($sql);
// $row = $rs->fetch_assoc();
// if($row){
// 	if($rec){
// 	//募集している科目があるとき
// 			while($row){
// 				$i = 0;
// 				if(!($row['tt_id'] === $rec[$i]['tt_id'])){			//同じ時間割で2回登録してしまうと、バグります。（2回目が、募集してない扱いで$norecに格納される。）
// 					array_push($norec, $row);		
// 				}
// 				--$i;
// 				$row = $rs->fetch_assoc();
// 			}
// 	}else{
// 	// 募集している科目がないときは全部入れる
// 		while($row){
// 			array_push($norec, $row);		
// 			$row = $rs->fetch_assoc();
// 		}
// 	}	
// }

$sql = <<<EOM
SELECT * FROM tb_timetable NATURAL JOIN tb_subject WHERE tt_id NOT IN
(SELECT tt_id FROM tb_teacher NATURAL JOIN tb_recruitment WHERE tea_id = '{$tea_id}') AND tea_id = '{$tea_id}'
EOM;

$rs = $conn->query($sql);
$row = $rs->fetch_assoc();                    //募集してる時間割情報(それ以外の時間割は募集してない)
while($row){
	array_push($norec, $row);
	$row= $rs->fetch_assoc();
}

//var_dump($rec);
//var_dump($norec);

?>
<h2>教員ホーム</h2>
<a class="btn btn-secondary btn-" href="#" role="button">学生を推薦をする</a>
<h3>担当科目一覧</h3>

<?php if($rec): ?>
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">募集状況</th>
      <th scope="col">科目名</th>
      <th scope="col">学期</th>
      <th scope="col">曜日</th>
      <th scope="col">時限</th>
      <th scope="col">募集人数</th>
      <th scope="col">応募人数</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
<?php for($i = 0; $i < count($rec); $i++): ?>
		<tr>
			<td scope="col">
				<span class="badge badge-primary">募集中</span></td>

<?php
					print('<td scope="col">'.$rec[$i]['sub_name'].'</td>');
				  print('<td scope="col">'.$semesters[$rec[$i]['semester']].'</td>');
				  print('<td scope="col">'.$weekdays[$rec[$i]['tt_weekday']].'</td>');
				  print('<td scope="col">'.$times[$rec[$i]['tt_timed']].'</td>');
				  print('<td scope="col">'.$rec[$i]['rec_num'].'人</td>');
				  echo '<td></td>';
?>
			<td scope="col">
				<a href="#" class="badge badge-info">編集</a>
			</td>
			<td scope="col">
				<?php 
				echo '<a href="?do=teacher_application_list&rec_id='.$rec[$i]['rec_id'].'" class="badge badge-info">募集者確認</a>'
				?>
			</td>
			</tr>
<?php endfor; ?>
  </tbody>
</table>
<?php 
endif; 

if($rec && $norec): ?>
<hr style="border:0;border-top:1px solid black;">
<?php 
endif;

if($norec): 
?>
<table class="table table-bordered">	
  <thead class="thead-light">
    <tr>
      <th scope="col">募集状況</th>
      <th scope="col">科目名</th>
      <th scope="col">学期</th>
      <th scope="col">曜日</th>
      <th scope="col">時限</th>
    </tr>
  </thead>
  <tbody>
<?php for($i = 0; $i < count($norec); $i++): ?>
	<tr>
	<td scope="col">
<?php
echo '<a href="?do=teacher_recruitment_add&tt_id='.$norec[$i]['tt_id'].'" class="badge badge-danger">募集する</a>';
?>
	</td>
<?php 
	print('<td scope="col">'.$norec[$i]['sub_name'].'</td>');
	print('<td scope="col">'.$semesters[$norec[$i]['semester']].'</td>');
	print('<td scope="col">'.$weekdays[$norec[$i]['tt_weekday']].'</td>');
	print('<td scope="col">'.$times[$norec[$i]['tt_timed']].'</td>');
	print('</tr>');
?>
<?php endfor; ?>
  </tbody>
</table>

<?php endif; ?>
