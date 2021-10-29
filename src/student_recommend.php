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
	<p class="red">以下から推薦の「了承」または「断る」を選択して、コメントを入力してください。</p>

	<div>
		<form action="?do=student_recommend_save" method="post" class="needs-validation" novalidate>

			      <fieldset class="form-group">
			        <div class="row">
			          <legend class="col-form-label col-sm-1 pt-0"><b>返答選択</b></legend>
			          <div class="col-sm-0">
			            <div class="form-check form-check-inline">
			              <input class="form-check-input" type="radio" name="rcm_result" id="rcm_result-form1" value="1" required>
			              <label class="form-check-label" for="rcm_result-form1">了承する</label>
			            </div>
			            <div class="form-check form-check-inline">
			              <input class="form-check-input" type="radio" name="rcm_result" id="rcm_result-form2" value="2" required>
			              <label class="form-check-label" for="rcm_result-form2">断る</label>
			            </div>
			          </div>
			        </div>
			      </fieldset>

			<div class="form-group">
	      		<label for="rcm-acomment"><b>返答文</b></label>
	      		<textarea class="form-control" id="rcm-acomment" name="rcm_acomment" rows="4" placeholder="連絡事項等を入力してください" required></textarea>
				<div class="invalid-feedback">
            		テキストエリアに文章を入力してください。
          		</div>
	      	</div>
	      	<input type="hidden" name="rcm_id" value="<?= $rcm_id;?>">
	      	<div style="text-align: right;">
		<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rsModal">
		  	送信
			</button>
	      	</div>
		<!-- Modal -->	
			<div class="modal fade" id="rsModal" tabindex="-1" aria-labelledby="molabel" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered">
			    <div class="modal-content">
			      <div class="modal-header">
			   		<h5 class="modal-title" id="molabel">確認</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			  			推薦を了承します。本当によろしいですか？
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	    	  		<button type="submit" class="btn btn-primary">送信</button>
	    	  	  </div>
		</form>
	<?php } ?>
</div>

<script src="../js/validation.js"></script>