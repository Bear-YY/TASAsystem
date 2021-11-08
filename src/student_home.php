<?php
require_once('db_inc.php');
include('data.php');
require_once('utils.php');
include('student_matching.php');
$timetable = array();
$rectt = [];				//応募中の時間割idを記録する。

//echo $mode;
$schflg = false;
$ttflg = false;
$recttflg = false;
$rcmflg = false;

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
$timetable = [];
while ($row) {
	$tt_id = $row['tt_id'];
	$timetable[$tt_id] = [
		'tt_timed' => $row['tt_timed'],
		'tt_weekday' => $row['tt_weekday'],
		'sub_name' => $row['sub_name']
	];
	$row = $rs->fetch_assoc();
}

//募集中の科目情報を取得
$sql = <<<EOM
SELECT * FROM tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_teacher NATURAL JOIN tb_subject
WHERE semester = '{$semester}' AND rec.tt_id = tt.tt_id
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$rectt = [];
while ($row) {
	$tt_id = $row['tt_id'];
	$rectt[$tt_id] = [
		'rec_id' => $row['rec_id'],
		'tea_name' => $row['tea_name'],
		'tt_timed' => $row['tt_timed'],
		'tt_weekday' => $row['tt_weekday'],
		'sub_name' => $row['sub_name'],
		'category_id' => $row['category_id']
	];
	$row = $rs->fetch_assoc();
}


//スケジュール情報を取得
$sql = <<<EOM
SELECT * FROM tb_schedule WHERE stu_id = '{$stu_id}' AND sch_semester = '{$semester}'
EOM;
$rs = $conn->query($sql);
if(!$rs) die('エラー: '. $conn->error);
$row = $rs->fetch_assoc();
$schs = [];
while ($row) {
	$sch_id = $row['sch_id'];
	$schs[$sch_id] = [
		'sch_timed' => $row['sch_timed'],
		'sch_weekday' => $row['sch_weekday'],
		'sch_name' => $row['sch_name']
	];
	$row = $rs->fetch_assoc();
}

//推薦が来ている時間割
$sql = <<<EOM
SELECT * FROM tb_recommend rcm , tb_recruitment rec, tb_timetable tt NATURAL JOIN tb_subject NATURAL JOIN tb_teacher
WHERE rcm.stu_id = '{$stu_id}' AND rcm.rec_id = rec.rec_id AND rec.tt_id = tt.tt_id
EOM;
$rs = $conn->query($sql);
if(!$rs) die('エラー: '. $conn->error);
$row = $rs->fetch_assoc();
$recommends = [];
while ($row) {
	$rcm_id = $row['rcm_id'];
	$recommends[$rcm_id] = [
		'rec_id' => $row['rec_id'],
		'sub_name' => $row['sub_name'],
		'tt_weekday' => $row['tt_weekday'],
		'tt_timed' => $row['tt_timed'],
		'semester' => $row['semester'],
		'tea_name' => $row['tea_name'],
		'tea_id' => $row['tea_id'],
		'tt_id' => $row['tt_id'],
	];
	$row = $rs->fetch_assoc();
}

//応募している時間割情報 サイドバー用
$sql = <<<EOM
SELECT * FROM tb_application app NATURAL JOIN tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_subject NATURAL JOIN tb_teacher
WHERE rec.tt_id = tt.tt_id AND stu_id = '{$stu_id}'
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$apps = [];
while($row){
	$app_id = $row['app_id'];
	$apps[$app_id] = [
		'app_result' => $row['app_result'],
		'sub_name' => $row['sub_name'],
		'tea_name' => $row['tea_name'],
		'semester' => $row['semester'],
		'tt_weekday' => $row['tt_weekday'],
		'tt_timed' => $row['tt_timed'],
		'rec_id' => $row['rec_id']
	];
	$row = $rs->fetch_assoc();
}


 ?>


<article>
	<div class="side">
		<!-- 最後のsql文の実行結果を取ってきてるので、配列に入れて管理する場合は注意 -->
		<?php
		listSide($apps, 0 , '応募中の時間割');
		listSide($apps, 1 , '採用された時間割');
		listSide($apps, 3 , '応募撤回した時間割');
		// listSide($apps, 2 , '不採用の時間割');
    if($recommends):
  	?>
    <div class="card bg-light mb-3" style="width: 12rem;" >
        <div class="card-header">
          推薦がある時間割
        </div>
        <?php
        	echo '<ul class="list-group list-group-flush">';
        	foreach ($recommends as $key => $value) {
        		echo '<li class="list-group-item">';
        			echo '<a href="?do=student_recommend&rcm_id='.$key.'"><b>'.$value['sub_name']; echo '</b></a><br>';
        			echo '・担当：'.$value['tea_name'].'<br>';
        			echo '・'.$semesters[$value['semester']].'-'.$weekdays_sm[$value['tt_weekday']].'-'.$times[$value['tt_timed']].'<br>';
        		echo '</li>';
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
<?php if($semester == 1): ?>
				<a href="?do=student_home&semester=2"><button type="button" class="btn btn-warning">後期</button></a>
<?php elseif($semester == 2): ?>
				<a href="?do=student_home&semester=1"><button type="button" class="btn btn-warning">前期</button></a>
<?php endif; ?>
			</div>
		</div>
		<table class="table table-bordered">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col" width="5%"></th>
		      <th scope="col" style="width: 19%;">月</th>
		      <th scope="col" style="width: 19%;">火</th>
		      <th scope="col" style="width: 19%;">水</th>
		      <th scope="col" style="width: 19%;">木</th>
		      <th scope="col" style="width: 19%;">金</th>
		    </tr>
		  </thead>
		  <tbody>
<?php
 for ($i=1; $i <= 6; $i++) {       //$iが時限　$jが曜日
		print('<tr scope = "row">');
		for ($j=0; $j < 6; $j++) {
			if($j === 0){
				print('<td>'.$i.'</td>');
			}else{
					print('<td');
					//スケジュールがあるかチェック
					$schflg = matchdayCheck($schs,'sch_weekday','sch_timed',$j,$i);
					if($schflg){
						echo ' class="table-danger">';
						foreach ($schs as $key => $value) {
							if(flagonCheck($schflg,$value['sch_weekday'],$value['sch_timed'],$j,$i)){
								echo '<b>予定あり</b>:'.$value['sch_name'].'<br>';
							}
						}
					}else{
						print('>');
					}
					//応募要件を満たしている科目のチャック(要件を満たす科目が1コマに2つある場合を考慮しなければならない)
					$ttflg = matchdayCheck($timetable,'tt_weekday','tt_timed',$j,$i);
					//募集されている科目があるのかを満たしている科目のチャック(募集科目が1コマに2つある場合を考慮しなければならない)
					$recttflg = matchdayCheck($rectt,'tt_weekday','tt_timed',$j ,$i);

					$rcmflg = matchdayCheck($recommends,'tt_weekday','tt_timed',$j ,$i);

					if($recttflg && $ttflg){
						foreach ($rectt as $key => $value) {
							if(flagonCheck($j, $i ,$value['tt_weekday'], $value['tt_timed'])){
								$catcount = 1;
								$quecount = 1;
								// if($mode == 'category'){
								foreach ($categorygpa as $key2 => $value2) {
									if($catcount > 2) {//表示させたい相性の良いカテゴリー順位を記入する。(2 ->1位、2位まで)
										break;
									}
									if($key2 == $value['category_id']){
										// echo 'カテゴリー相性：良!!'.$catcount.'<br>';　//デバック用
										echo '<span class="badge badge-success">▼カテゴリー相性：良!!</span><br>';
									}
									$catcount++;
								}
								// }
								if($mode == 'questionnaire'){
									foreach ($categoryscore as $key3 => $value3) {
										if($quecount > 2) {//表示させたい相性の良いアンケート結果順位を記入する。(2 ->1位、2位まで)
											break;
										}
										if($key3 == $key){
											// echo '適性相性：良!!'.$quecount.'<br>';　//デバック用
											echo '<span class="badge badge-success">▼適性相性：良!!</span><br>';
										}
										$quecount++;
									}
								}
								if($schflg){
									// echo '<b>・'.mb_substr($value['sub_name'],0,8).'...</b><br>--'.$value['tea_name'].'<br>';   //時間割名の後半を省略
									echo '<b>・'.$value['sub_name'].'</b><br>--'.$value['tea_name'].'<br>';
								}else{
									if($rcmflg){
										foreach ($recommends as $key4 => $value4) {
											if(flagonCheck($j, $i ,$value4['tt_weekday'], $value4['tt_timed'])){
												echo '<a href="?do=student_recommend&rcm_id='.$key4.'">';
											}
										}
									}else{
										echo '<a href="?do=student_application&rec_id='.$value['rec_id'].'">';
									}
										// echo '<b>・'.mb_substr($value['sub_name'],0,8).'...</b><br>--'.$value['tea_name'].'<br><a>';　//時間割名の後半を省略
										echo '<b>・'.$value['sub_name'].'</b><br>--'.$value['tea_name'].'<br><a>';
								}
							}
						}
					}
					print('</td>');
			}

			$schflg = false;
			$ttflg = false;
			$recttflg = false;
			$rcmflg = false;
	 	}
	 print('</tr>');
}
  ?>
		  </tbody>
		</table>

	</div>
</article>
