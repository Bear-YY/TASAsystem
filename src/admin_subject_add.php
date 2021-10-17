
<div id="app1">
<!-- <p>{{message}}</p> -->
	<div class="main">
		<h1>科目登録</h1>
<!-- 		デバック用に切り替えて(上のほうがデバック用)-->		
		<form action="?do=" method="post">
		<!-- <form action="?do=eps_subject" method="post"> -->

			<div class="form-group">
				<label for="sub_name-form">科目名</label>
				<input type="text" class="form-control" name="sub_name" id="sub_name-form" placeholder="例:プログラミング基礎">
			</div>
			<div class="form-group">
				<label for="dpt_id-form">学部・学科</label>
				<input type="text" class="form-control" name="dpt_id" id="dpt_id-form" placeholder="例:RS">
			</div>
			<div class="form-group">
				<label for="get_year-form">学年</label>
				<select class="form-control" id="get_year-form" name="get_year">
				  <option selected>未選択</option>
				  <option value="1">1年生</option>
				  <option value="2">2年生</option>
				  <option value="3">3年生</option>
				  <option value="4">4年生</option>
				</select>
			</div>
			<div class="form-group">
				<label for="sub_unit-form">取得単位数</label>
				<input type="number" class="form-control" name="sub_unit" id="sub_unit-form" placeholder="数字のみしか入力できません。">
			</div>
			<div class="form-group">
				<label for="sub_section-form">科目区分</label>
				<select class="form-control" id="sub_section-form" name="sub_section">
				  <option selected>未選択</option>
				  <option value="1">必修科目</option>
				  <option value="3">選択科目</option>
				  <option value="2">導入科目</option>
				  <option value="4">教養科目</option>
				</select>
			</div>
			<button type="submit" class="btn btn-primary">登録</button>
		</form>
		
	</div>
	
</div>

<script src="js/admin.js"></script>


<?php
