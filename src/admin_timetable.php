<?php 
require_once('db_inc.php');
include('data.php');
$sub_id = $_GET['sub_id'];
$timetable = [];

$sql = <<<EOM
SELECT * FROM tb_subject NATURAL JOIN tb_timetable NATURAL JOIN tb_teacher WHERE sub_id = '1';
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$sub_name = $row['sub_name'];
$timetable = [];
while($row){
	$tt_id = $row['tt_id'];
	$timetable[$tt_id] = [
		'tea_name' => $row['tea_name'],
		'semester' => $row['semester'],
		'tt_weekday' => $row['tt_weekday'],
		'tt_timed' => $row['tt_timed'],
		'tt_year' => $row['tt_year'],
		'tt_classnum' => $row['tt_classnum']
	];
	$row = $rs->fetch_assoc();
}

?>

<?php 
if($timetable){
	echo '<h4>['.$sub_name.']の登録済み時間割</h4>';
?>

<div >
   <table class="table table-sm table-bordered">
     <thead class="thead-dark"> 
       <tr>
           <th scope="col">教員名</th>
           <th scope="col">学期</th>
           <th scope="col">曜日</th>
           <th scope="col">時限</th>
           <th scope="col">年度</th>
           <th scope="col">教室番号</th>
         </tr>
     </thead>  
       <tbody>
       	<?php foreach ($timetable as $key => $value):?>
         <tr>
           <td><?= $value['tea_name']; ?></td>
           <td><?= $value['semester']; ?></td>
           <td><?= $value['tt_weekday']; ?></td>
           <td><?= $value['tt_timed']; ?></td>
           <td><?= $value['tt_year']; ?></td>
           <td><?= $value['tt_classnum']; ?></td>
         </tr>
     	<?php endforeach; ?>
       </tbody>
   </table>
</div>
<hr style="border:0;border-top:1px solid black;">

<?php  
}
?>
<h4>時間割の新規登録</h4>
<form action="?do=" method="post">
	<div class="form-group col-md-6"> <!-- 6マス使います的な？ -->
		<label for="tea_id-form" >教員ID</label>
		<input type="text" class="form-control" name="tea_id" id="tea_id-form" placeholder="例:プログラミング基礎">
	</div>
	<input type="hidden" name="sub_id" value="<?= $sub_id ;?>">
	<div class="form-group row col-sm-9 mb-2"> <!-- mbが下との幅と思われる sm-9は9マス -->
		<div class="col-md-3">
			<label for="semester-form">学期</label>
			<select class="form-control" id="sub_section-form" name="semester">
			  <option selected disabled>未選択</option>
			  <option value="1">前期</option>
			  <option value="3">後期</option>
			</select>
		</div>
		<div class="col-md-3">
		<label for="tt_weekday-form">曜日</label>
			<select class="form-control" id="tt_weekday-form" name="tt_weekday">
			  <option selected disabled>未選択</option>
			  <option value="1">月曜日</option>
			  <option value="2">水曜日</option>
			  <option value="3">火曜日</option>
			  <option value="4">木曜日</option>
			  <option value="5">金曜日</option>
			  <option value="6">土曜日</option>
			</select>
		</div>
		<div class="col-md-3">
			<label for="tt_timed-form">時限</label>
			<select class="form-control" id="tt_timed-form" name="tt_timed">
			  <option selected disabled>未選択</option>
			  <option value="1">1限目</option>
			  <option value="2">2限目</option>
			  <option value="3">3限目</option>
			  <option value="4">4限目</option>
			  <option value="5">5限目</option>
			  <option value="6">6限目</option>
			  <option value="7">7限目</option>
			</select>
		</div>
	</div>
	<div class="form-group col-md-2"> <!-- 6マス使います的な？ -->
		<label for="tt_year-form" >年度</label>
		<input type="number" class="form-control" name="tt_year" id="tt_year-form" placeholder="例:2021">
	</div>
	<div class="form-group col-md-4"> <!-- 6マス使います的な？ -->
		<label for="tt_classnum-form" >教室番号</label>
		<input type="text" class="form-control" name="tt_classnum" id="tt_classnum-form" placeholder="例:12105">
	</div>
	<button type="submit" class="btn btn-primary">登録</button>
</form>