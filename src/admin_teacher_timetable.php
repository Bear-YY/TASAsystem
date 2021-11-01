<?php  
require_once('db_inc.php');
require_once('data.php');
require_once('utils.php');

$tea_id = $_GET['tea_id'];
$sql = "SELECT * FROM tb_teacher WHERE tea_id = '{$tea_id}'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();                    //募集してる時間割情報(それ以外の時間割は募集してない)
$tea_name = $row['tea_name'];
// 募集している時間割情報を取得
$sql = 
"SELECT * FROM tb_teacher tea NATURAL JOIN tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_subject sub
WHERE rec.tea_id = '{$tea_id}' AND rec.tt_id = tt.tt_id ORDER BY semester , tt_weekday , tt_timed";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();                    //募集してる時間割情報(それ以外の時間割は募集してない)
$rectt = [];
while($row){
	$rec_id = $row['rec_id'];
	$rectt[$rec_id] = [	
		'sub_name' => $row['sub_name'],
		'semester' => $row['semester'],
		'tt_weekday' => $row['tt_weekday'],
		'tt_timed' => $row['tt_timed'],
		'rec_num' => $row['rec_num'],
		'tt_id' => $row['tt_id']
	];
	$row= $rs->fetch_assoc();
}

if($rectt){
	foreach ($rectt as $key => $value) {
		//応募人数を出して$recttにつっこむ
		$rec_id = $key;
		$sql = <<<EOM
			SELECT *,count(*) AS totalapp FROM tb_application WHERE rec_id = '{$rec_id}'
		EOM;
		$rs = $conn->query($sql);
		$row = $rs->fetch_assoc();
		$rectt[$key]['totalapp'] = $row['totalapp'];	
		//採用に人数を出してつっこむ
		$sql = <<<EOM
			SELECT *,count(*) AS decideapp FROM tb_application WHERE rec_id = '{$rec_id}' AND app_result = '1'
		EOM;
		$rs = $conn->query($sql);
		$row = $rs->fetch_assoc();
		$rectt[$key]['decideapp'] = $row['decideapp'];	
	}
}

//募集していない時間割情報を取得
$sql = <<<EOM
SELECT * FROM tb_timetable NATURAL JOIN tb_subject WHERE tt_id NOT IN
(SELECT rec.tt_id FROM tb_teacher tea NATURAL JOIN tb_recruitment rec,tb_timetable tt NATURAL JOIN tb_subject sub
WHERE rec.tea_id = '{$tea_id}' AND rec.tt_id = tt.tt_id) AND tea_id = '{$tea_id}' ORDER BY semester , tt_weekday , tt_timed
EOM;
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$row = $rs->fetch_assoc();                    //募集してる時間割情報(それ以外の時間割は募集してない)
$timetable = [];
while($row){
	$tt_id = $row['tt_id'];
	$timetable[$tt_id] = [	
		'sub_name' => $row['sub_name'],
		'semester' => $row['semester'],
		'tt_weekday' => $row['tt_weekday'],
		'tt_timed' => $row['tt_timed'],
	];
	$row= $rs->fetch_assoc();
}

//推薦をしている科目
$sql = <<<EOM
select * from tb_recruitment rec, tb_timetable tt natural join tb_subject natural join tb_recommend
where rec.tt_id = tt.tt_id and rec.rec_id in
(select rec_id from tb_recommend where tea_id = '{$tea_id}') ORDER BY semester , tt_weekday , tt_timed
EOM;
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$row = $rs->fetch_assoc();                    //募集してる時間割情報(それ以外の時間割は募集してない)
$rcmtt = [];
while($row){
	$rcm_id = $row['rcm_id'];
	$rcmtt[$tt_id] = [	
		'sub_name' => $row['sub_name'],
		'semester' => $row['semester'],
		'tt_weekday' => $row['tt_weekday'],
		'tt_timed' => $row['tt_timed'],
	];
	$row= $rs->fetch_assoc();
}
?>

<h3>--<?= $tea_name; ?>様--の担当時間割</h3>
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
        <th scope="col">採用人数</th>
        <th scope="col"></th>
      </tr>
  </thead>  
    <tbody>
    <?php foreach((array)$rectt as $key => $value): ?>
      <tr>
        <td class="table-primary" align="center"><b>募集中</b></td>
        <td><?=$value['sub_name']; ?></td>
        <td><?=$semesters[$value['semester']]; ?></td>
        <td><?=$weekdays[$value['tt_weekday']]; ?></td>
        <td><?=$times[$value['tt_timed']]; ?></td>
        <td><?=$value['rec_num']; ?>人</td>
        <td><?=$value['totalapp']; ?>人</td>
        <td><?=$value['decideapp']; ?>人</td>
        <td align="center"><a class="btn btn-secondary" href="?do=admin_teacher_application&rec_id=<?= $key; ?>" role="button">応募者</a></td>
      </tr>
  	<?php endforeach; ?>
  	<?php foreach($timetable as $key => $value): ?>
      <tr>
        <td class="table-secondary" align="center"><b>未募集</b></td>
        <td><?=$value['sub_name']; ?></td>
        <td><?=$semesters[$value['semester']]; ?></td>
        <td><?=$weekdays[$value['tt_weekday']]; ?></td>
        <td><?=$times[$value['tt_timed']]; ?></td>
        <!-- <td></td> -->
        <!-- <td></td> -->
        <!-- <td></td> -->
        <!-- <td></td> -->
      </tr>
  	<?php endforeach; ?>
    </tbody>
</table>

<?php if($rcmtt): ?>
<h3>--<?= $tea_name; ?>様--の推薦を行っている時間割</h3>
<table class="table table-bordered">
  <thead class="thead-dark"> 
    <tr>
        <th scope="col">科目名</th>
        <th scope="col">学期</th>
        <th scope="col">曜日</th>
        <th scope="col">時限</th>
        <th scope="col"></th>
      </tr>
  </thead>  
  <tbody>
  	<?php foreach($rcmtt as $key => $value): ?>
    <tr>
       <td><?=$value['sub_name']; ?></td>
       <td><?=$semesters[$value['semester']]; ?></td>
       <td><?=$weekdays[$value['tt_weekday']]; ?></td>
       <td><?=$times[$value['tt_timed']]; ?></td>
       <td align="center"><a class="btn btn-secondary" href="?do=admin_teacher_recommend&rcm_id=<?= $key; ?>" role="button">推薦者</a></td>
    </tr>
 	<?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
