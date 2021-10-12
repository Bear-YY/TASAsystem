<?php 
require_once('db_inc.php');
require_once('data.php');
$timetable = array();     
$rectt = [];				//応募中の時間割idを記録する。
$semester = 1;					//学期の検索対象  デフォルトでは前期を指定している。(1 => 前期、2 => 後期)
if(isset($_GET['semester'])){
	$semester = $_GET['semester'];
}
$usr_id = $_SESSION['usr_id'];
$stu_id = strtoupper($usr_id);
$stu_id = mb_substr($stu_id, 1);

// 学生が応募要件(成績A以上)を満たしている科目のみを取得
$sql = <<<EOM
SELECT * FROM tb_student NATURAL JOIN tb_course NATURAL JOIN tb_subject NATURAL JOIN tb_timetable 
WHERE stu_id = '{$stu_id}' AND grade <= 2 AND semester = '{$semester}'
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
while ($row) {
	$timetable[$row['sub_name']][$row['tt_weekday']][$row['tt_timed']] = $row['tt_id'];     //この配列だと同じ名前、時間割での科目が上書きされる？要検討
	$row = $rs->fetch_assoc();
}

//募集中の科目情報を取得
$sql = <<<EOM
SELECT * FROM tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_teacher
WHERE semester = '{$semester}' AND rec.tt_id = tt.tt_id
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
while ($row) {
	$rectt[$row['tt_id']] = $row['rec_id'];
	$row = $rs->fetch_assoc();
}
//var_dump($timetable);
// var_dump($rectt);

//応募中の科目はサイドバーにでも表示する。
//応募中の科目を押したら、募集中です的な文字をだす.?
//$danger みたいに管理する。

//サイドバーに表示するための応募している科目情報を取得
$sql = <<<EOM
SELECT * FROM tb_application app NATURAL JOIN tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_subject
WHERE rec.tt_id = tt.tt_id AND stu_id = '{$stu_id}'
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
 ?>




<article>
	<div class="side">
		<div class="bcenter">
				<a href="?do=student_schedule"><button type="button" class="btn btn-info">スケジュール表<br>登録・編集</button></a>
		</div>
		<div class="bcenter">
				<a href="?do=student_answer"><button type="button" class="btn btn-info">アンケート回答</button></a>
		</div>
		<!-- 最後のsql文の実行結果を取ってきてるので、配列に入れて管理する場合は注意 -->
		<?php if($row): ?>				
		<div class="card bg-light mb-3" style="width: 12rem;" >
        <div class="card-header">
          応募中の時間割
        </div>
        <?php
        	echo '<ul class="list-group list-group-flush">';
        	while($row){ 
        		echo '<li class="list-group-item">'.$row['sub_name'].'</li>';
        		$row = $rs->fetch_assoc();
        	}
        	echo '</ul>';
        ?>
    </div>
  <?php endif; ?>
	</div>
	<div class="main">
		<h3>応募可能科目一覧</h3>
		<div style="display: flex;">
			<div style="padding: 12px;">
				<h4><?= $semesters[$semester];?></h4>
			</div>
			<div style="margin: 10px;">
				<a href="?do=student_home&semester=1"><button type="button" class="btn btn-warning">前期</button></a>
				<a href="?do=student_home&semester=2"><button type="button" class="btn btn-warning">後期</button></a>
			</div>
		</div>
		<table class="table table-bordered">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col" width="5%"></th>
		      <th scope="col">月</th>
		      <th scope="col">火</th>
		      <th scope="col">水</th>
		      <th scope="col">木</th>
		      <th scope="col">金</th>
		    </tr>
		  </thead>
		  <tbody>
<?php 
 for ($i=1; $i < 7; $i++) {       //$iが時限　$jが曜日
		print('<tr scope = "row">');
		for ($j=0; $j < 6; $j++) { 
			if($j === 0){
				print('<td>'.$i.'</td>');
			}else{
					print('<td');
					if(false){
						print(' class="table-danger"');
						$danger = true;
					}
					print('>');
					foreach ($timetable as $key => $value) {
						if(isset($value[$j][$i])){
							foreach ($rectt as $key2 => $value2) {
								if(($value[$j][$i] === (string)$key2) && $danger){
									echo '<a>'.$key.'<a>';
								}elseif($value[$j][$i] === (string)$key2){
									echo '<a href="?do=student_application&rec_id='.$value2.'">・'.$key.'<br>--teacher<a>';
								}
							}
						}
					}
					print('</td>');
			}
			$danger = false;
	 	}
	 print('</tr>');
}
  ?>		  	
		  </tbody>
		</table>
		
	</div>
</article>