
<!-- <p>{{message}}</p> -->

	<div class="main">
		<h1>アンケート登録</h1>
<!-- 		デバック用に切り替えて(上のほうがデバック用)-->		
		<form action="?do=admin_questionnaire_save" method="post">
		<!-- <form action="?do=eps_subject" method="post"> -->

			<div class="form-group">
				<label for="sub_name-form">科目名</label>
				<input type="text" class="form-control" name="sub_name" id="sub_name-form" placeholder="例:プログラミング基礎">
			</div>
			<button type="submit" class="btn btn-primary">登録</button>
		</form>
		
	</div>

<script src="js/admin.js"></script>


<?php
