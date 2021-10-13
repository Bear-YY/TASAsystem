<?php 
require_once('db_inc.php');
require_once('data.php');
$rcm_id = $_GET['rcm_id'];

$sql = <<<EOM
SELECT * FROM tb_recommend rcm , tb_recruitment rec, tb_timetable tt NATURAL JOIN tb_subject NATURAL JOIN tb_teacher
WHERE rcm.rcm_id = '$rcm_id' AND rcm.rec_id = rec.rec_id AND rec.tt_id = tt.tt_id
EOM;
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
 ?>


<div class="main">
	 <div class="tablearea-sm">
	   <div>
	       <h2>募集時間割</h2>
	   </div>
	   <table class="table table-sm table-bordered">
	     <tbody>
	       <tr>
	         <th scope="row" width="25%" class="table-secondary">科目名</th>
	         <td><?= $row['sub_name']; ?></td>
	       </tr>
	       <tr>
	         <th scope="row" class="table-secondary">担当教員</th>
	         <td><?= $row['tea_name']; ?></td>
	       </tr>
	      <tr>
	         <th scope="row" class="table-secondary">学期</th>
	         <td><?= $semesters[$row['semester']];?></td>
	       </tr>
	       <tr>
	         <th scope="row" class="table-secondary">曜日</th>
	         <td><?= $weekdays[$row['tt_weekday']]; ?></td>
	       </tr>
	       <tr>
	         <th scope="row" class="table-secondary">時限</th>
	         <td><?= $times[$row['tt_timed']]; ?></td>
	       </tr>
	       <tr>
	         <th scope="row" class="table-secondary">募集役割</th>
	         <td><?= $role[$row['role_id']]; ?></td>
	       </tr>
	       <tr>
	         <th scope="row" class="table-secondary">回答期日</th>
	         <td><?= $row['rcm_deadline']; ?></td>
	       </tr>
	       <tr>
	         <th scope="row" class="table-secondary">教員コメント</th>
	         <td><?= $row['rcm_comment']; ?></td>
	       </tr>
	       

	     </tbody>
	   </table>
	</div>

	
	<hr style="border:0;border-top:1px solid black;">
	<?php 
	if($row['rcm_result'] == 1){
		echo '<p>あなたは推薦了承済みです。</p>';
	}else if($row['rcm_result'] == 2){
		echo '<p>あなたは推薦拒否済みです。</p>';
	}else{


	 ?>

	<p class="red">あなたはこの時間割において、教員から推薦されています。</p>
	<p class="red">推薦を了承する場合は①へ、推薦を受けない場合は②へと進んでください。</p>

	<div>
		<?php for($i = 0; $i <= 1; $i++): ?>
		<form action="?do=student_recommend_save" method="post">
			<div class="form-group">
			<?php  
			if($i === 0){
	      	    echo '<label for="rcm-acomment">①推薦了承</label>';
	      	    echo '<textarea class="form-control" id="rcm-acomment" name="rcm_acomment" rows="4" placeholder="連絡事項等を入力してください"></textarea>';
	      	}
	      	if($i === 1){
	      	    echo '<label for="rcm-acomment">②推薦を断る</label>';
	      		echo '<textarea class="form-control" id="rcm-acomment" name="rcm_acomment" rows="4" placeholder="断る理由を簡潔に記入してください"></textarea>';
	      	}
			?>
	      	</div>
	      	<input type="hidden" name="rcm_id" value="<?= $rcm_id;?>">
	      	<div style="text-align: right;">
	      	
		<!-- Button trigger modal -->
	      	<?php 
			if($i === 0){	
			echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rsModal0">';
		  	echo '送信(了承)';
			}
			if($i === 1){	
			echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rsModal1">';
		  	echo '送信(断る)';
			}
			?>
			</button>
	      	</div>

		<!-- Modal -->		
			<?php 
			if($i === 0){	
			echo '<div class="modal fade" id="rsModal0" tabindex="-1" aria-labelledby="molabel0" aria-hidden="true">';
			}
			if($i === 1){	
			echo '<div class="modal fade" id="rsModal1" tabindex="-1" aria-labelledby="molabel1" aria-hidden="true">';
			}

			?>
			  <div class="modal-dialog modal-dialog-centered">
			    <div class="modal-content">
			      <div class="modal-header">
			<?php 
			if($i === 0){	
			    echo '<h5 class="modal-title" id="molabel0">確認</h5>';
			}
			if($i === 1){	
			    echo '<h5 class="modal-title" id="molabel1">注意：確認</h5>';
			}

			?>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			<?php 
			if($i === 0){	
				echo '<input type="hidden" name="rcm_result" value="1">';
			    echo '推薦を了承します。本当によろしいですか？';
			}
			if($i === 1){	
				echo '<input type="hidden" name="rcm_result" value="2">';
			    echo '推薦を拒否します。本当によろしいですか？';
			}

			?>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <?php  
	    	  		if($i === 0){
	    	  			echo '<button type="submit" class="btn btn-primary">送信(了承)</button>';
	    	  		}
	    	  		if($i === 1){
	    	    		echo '<button type="submit" class="btn btn-primary">送信(断る)</button>';
	    	  		}
					?>
			      </div>
			    </div>
			  </div>
			</div>
		</form>



		<?php endfor; ?>
	</div>
	<?php 
	}
	 ?>
</div>