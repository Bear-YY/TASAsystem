<?php
require_once('utils.php'); 
require_once('data.php');
$rec_id = $_POST['rec_id'];
$stu_id = $_POST['stu_id'];
$tea_id = $_POST['tea_id'];

$stu_name = $_POST['stu_name'];
$ad_year = $_POST['ad_year'];

$today = getToday();
 ?>
<article>
	<div class="main">
		<h3>推薦対象学生</h3>
		<div class="tablearea-sm">
			<table class="table table-sm table-bordered">
    		  <tbody>
    		    <tr>
    		      <th scope="row" class="table-secondary">学籍番号</th>
    		      <td width="50%"><?= $stu_id; ?></td>
    		    </tr>
    		    <tr>
    		      <th scope="row" class="table-secondary">氏名</th>
    		      <td><?= $stu_name; ?></td>
    		    </tr>
    		    <tr>
    		      <th scope="row" class="table-secondary">学年</th>
    		      <?php 
    		      	$year = $fake_year - $ad_year;
    		       ?>
    		      <td><?= $school_grade[$year];?></td>
    		    </tr>
    		  </tbody>
    		</table>
		</div>
		<hr style="border:0;border-top:1px solid black;">
		<div class="rcm-form">	
			<form action="?do=teacher_recommend_save" method="post">
				<div class="form-group" style="width: 200px;">
			 	  <label for="rcm-dl">返答締め切り</label>
				  <input class="form-control" type="date" name="rcm_deadline" value="<?= $today;?>" id="rcm-dl">
				</div>
				<div class="form-group" style="width: 70%;">
			 	  <label for="rcm-comment-ta">推薦コメント</label>
			 	  <textarea class="form-control" name="rcm_comment" id="rcm-comment-ta" rows="3"></textarea>
			 	</div>
			 	<input type="hidden" name="rec_id" value="<?= $rec_id;?>">
			 	<input type="hidden" name="stu_id" value="<?= $stu_id;?>">
			 	<input type="hidden" name="tea_id" value="<?= $tea_id;?>">
				<button type="submit" class="btn btn-primary">推薦送信</button>
			</form>
		</div>
	</div>
</article>