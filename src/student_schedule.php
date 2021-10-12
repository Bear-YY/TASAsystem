<?php 
require_once('db_inc.php');
require_once('data.php');
$usr_id = $_SESSION['usr_id'];
$stu_id = strtoupper($usr_id); //全部大文字
$stu_id = mb_substr($stu_id, 1);  //頭の一文字を消す(細かい使い方は調べましょう)
$schflg = false;

$semester = 1;					//学期の検索対象  デフォルトでは1(前期)を指定している。(1 => 前期、2 => 後期)
if(isset($_GET['semester'])){
	$semester = $_GET['semester'];
}

$sql = <<<EOM
SELECT * FROM tb_schedule WHERE stu_id = '{$stu_id}' AND sch_semester = '{$semester}'
EOM;
$rs = $conn->query($sql);
if(!$rs) die('エラー: '. $conn->error);
$row = $rs->fetch_assoc();

$schs = [];
while($row){
		$sch_id = $row['sch_id'];
		$schs[$sch_id] = [
			'sch_name' => $row['sch_name'],
			'sch_weekday' => $row['sch_weekday'],
			'sch_timed' => $row['sch_timed'],
			'sch_detail' => $row['sch_detail'],
			'sch_semester' => $row['sch_semester']
		];
		$row = $rs->fetch_assoc();
}

//var_dump($schs);

 ?>
<article>
	<div class="main">
		<h2>スケジュール</h2>
		<div style="display: flex;">	
			<div style="padding: 12px;">
					<h4><?= $semesters[$semester];?></h4>
			</div>
			<div style="margin: 10px;">
					<a href="?do=student_schedule&semester=1"><button type="button" class="btn btn-warning">前期</button></a>
					<a href="?do=student_schedule&semester=2"><button type="button" class="btn btn-warning">後期</button></a>
				</div>
		</div>
		<table class="table table-bordered">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col" width="5%"></th>
		      <th scope="col" width="19%">月</th>
		      <th scope="col" width="19%">火</th>
		      <th scope="col" width="19%">水</th>
		      <th scope="col" width="19%">木</th>
		      <th scope="col" width="19%">金</th>
		    </tr>
		  </thead>
		  <tbody>
<?php 
 for ($i=1; $i <= 6; $i++) {               //$iが時限　$jが曜日
		print('<tr scope = "row">');
		for ($j=0; $j < 6; $j++) { 
			if($j === 0){
				print('<th>'.$i.'</th>');
			}else{
					$act = 'insert';
					print('<td>');

					foreach ($schs as $key => $value) {
						if(($value['sch_weekday'] === (string)$j) && ($value['sch_timed'] === (string)$i)){
							$sch_name = $value['sch_name'];
							$schflg = true;
							break;
						}
					}
					if($schflg){
						$act = 'delete';
?>
<div class="card border-secondary mb-3">
  <div class="card-header"><?= $sch_name;?></div>
  <div class="card-body text-secondary">
    <h5 class="card-title">予定詳細</h5>
    <!-- テキストエリアで入力した値の改行は<pre><pre>でも使えるが、<>,&などは実体参照する必要あり -->
    <p class="card-text"><?= nl2br($value['sch_detail']);?></p> 
    	<div align="right">
			<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalSchedule-del-<?= $j.$i;?>">
			  削除
			</button>
			</div>
			<div class="modal fade" id="modalSchedule-del-<?= $j.$i;?>" tabindex="-1" aria-labelledby="del-label-<?= $j.$i;?>" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			    <form action="?do=student_schedule_save" method="post">
			    	<input type="hidden" name="act" value="<?= $act ;?>">
			    	<input type="hidden" name="sch_id" value="<?= $key ;?>">
			    	<input type="hidden" name="sch_semester" value="<?= $semester;?>">
			    	<div class="modal-content">
			    	  <div class="modal-header">
			    	    <h5 class="modal-title" id="del-label-<?= $j.$i;?>">警告</h5>
			    	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    	      <span aria-hidden="true">×</span>
			    	    </button>
			    	  </div>
			    	  <div class="modal-body">
			    	  	このスケジュールを削除しますか？
			    	  </div>
			    	  <div class="modal-footer">
			    	    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			    	    <button type="submit" class="btn btn-danger">削除</button>
			    	  </div>
			    	</div>
				</form>
			  </div>
			</div>

  </div>
</div>



<?php 
}else{
 ?>
	<!-- Button trigger modal -->
	<div>
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalSchedule-<?= $j.$i;?>">
	  登録
	</button>
	</div>
	<div class="modal fade" id="modalSchedule-<?= $j.$i;?>" tabindex="-1" aria-labelledby="label-<?= $j.$i;?>" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
	    <form action="?do=student_schedule_save" method="post">
	    	<div class="modal-content">
	    	  <div class="modal-header">
	    	    <h5 class="modal-title" id="label-<?= $j.$i;?>">スケジュールを登録してください</h5>
	    	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	    	      <span aria-hidden="true">×</span>
	    	    </button>
	    	  </div>
	    	  <div class="modal-body">
						<input type="hidden" name="sch_weekday" value="<?= $j;?>">
						<input type="hidden" name="sch_timed" value="<?= $i;?>">
						<input type="hidden" name="sch_semester" value="<?= $semester;?>">
						<input type="hidden" name="act" value="<?= $act;?>">

						<h2><?= $weekdays[$j].'-'.$times[$i].'目'; ?></h2>
						<div class="form-group">
							<label for="sch_title-form">スケジュール名</label>
							<input type="text" class="form-control" name="sch_name" id="sch_title-form" placeholder="例:離散数学">
  					</div>
						<div class="form-group">
							<label for="sch_detail-form">スケジュール詳細</label>
    					<textarea class="form-control" id="sch_detail-form" rows="3" name="sch_detail"></textarea>
  					</div>
	    	  </div>
	    	  <div class="modal-footer">
	    	    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	    	    <button type="submit" class="btn btn-primary">登録</button>
	    	  </div>
	    	</div>
		</form>
	  </div>
	</div>
<?php 
					}		
				print('</td>');
	 			$schflg = false;
			}
	 	}
	 print('</tr>');
}
  ?>		  	
			</tbody>
		</table>
		<button type="button" class="btn btn-secondary" onclick="history.back()">学生ホームに戻る</button>
	</div>	
</article>