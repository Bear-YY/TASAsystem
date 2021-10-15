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
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brush" viewBox="0 0 16 16">
  <path d="M15.825.12a.5.5 0 0 1 .132.584c-1.53 3.43-4.743 8.17-7.095 10.64a6.067 6.067 0 0 1-2.373 1.534c-.018.227-.06.538-.16.868-.201.659-.667 1.479-1.708 1.74a8.118 8.118 0 0 1-3.078.132 3.659 3.659 0 0 1-.562-.135 1.382 1.382 0 0 1-.466-.247.714.714 0 0 1-.204-.288.622.622 0 0 1 .004-.443c.095-.245.316-.38.461-.452.394-.197.625-.453.867-.826.095-.144.184-.297.287-.472l.117-.198c.151-.255.326-.54.546-.848.528-.739 1.201-.925 1.746-.896.126.007.243.025.348.048.062-.172.142-.38.238-.608.261-.619.658-1.419 1.187-2.069 2.176-2.67 6.18-6.206 9.117-8.104a.5.5 0 0 1 .596.04zM4.705 11.912a1.23 1.23 0 0 0-.419-.1c-.246-.013-.573.05-.879.479-.197.275-.355.532-.5.777l-.105.177c-.106.181-.213.362-.32.528a3.39 3.39 0 0 1-.76.861c.69.112 1.736.111 2.657-.12.559-.139.843-.569.993-1.06a3.122 3.122 0 0 0 .126-.75l-.793-.792zm1.44.026c.12-.04.277-.1.458-.183a5.068 5.068 0 0 0 1.535-1.1c1.9-1.996 4.412-5.57 6.052-8.631-2.59 1.927-5.566 4.66-7.302 6.792-.442.543-.795 1.243-1.042 1.826-.121.288-.214.54-.275.72v.001l.575.575zm-4.973 3.04.007-.005a.031.031 0 0 1-.007.004zm3.582-3.043.002.001h-.002z"/>
</svg>
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
	</div>	
</article>