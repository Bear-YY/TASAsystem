<?php 
require_once('db_inc.php');
$sql = "SELECT * FROM tb_questionnaire";

$rs = $conn->query($sql);
if(!$rs) die('エラー: '. $conn->error);
$row = $rs->fetch_assoc();
?>

<article>
<div class="side">

<p>サイドバー</p>
</div>

<div class="main">

<!-- 	<p>{{message}}</p> -->
	
	<!-- Button trigger modal -->
	<div class="left-content">
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-queadd">
	  アンケート登録
	</button>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="modal-queadd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
	    <form action="?do=admin_questionnaire_save" method="post">
	    	<div class="modal-content">
	    	  <div class="modal-header">
	    	    <h5 class="modal-title" id="exampleModalLabel">追加する項目名を入力してください</h5>
	    	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	    	      <span aria-hidden="true">×</span>
	    	    </button>
	    	  </div>
	    	  <div class="modal-body">
	    	  	<div class="form-group">
					<label for="que_title-form"></label>
					<input type="text" class="form-control" name="que_title" id="que_title-form" placeholder="例:○○が好き">
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

<?php if (!$row):
echo "<div>";
echo "<h3>・アンケートは登録されていません。</h3>";
echo "<h3>・[アンケート登録ボタン]から登録してください。</h3>";
echo "</div>";
?>

<?php else: ?>

<table class="table table-bordered">
<thead class="thead-dark">
<tr>
<th scope="col" width="10%">番号</th>
<th scope="col">項目内容</th>
<th scope="col">操作</th>

</tr>
</thead>
<tbody>

<?php
while($row){
?>

<tr>
<th scope="row">
<?php 
//echo '<a href="https://getbootstrap.com/docs/4.5/content/tables/">';  //1.
echo $row['que_id'].'</th>';
//echo '</a>';															//2. 2つでリンクをつけられる
echo '<td>'.$row['que_title'].'</td>';

?>
<td align="center"><a class="btn btn-secondary btn-sm" href="https://getbootstrap.com/docs/4.5/components/buttons/" role="button">編集</a>
<a class="btn btn-danger btn-sm" href="https://getbootstrap.com/docs/4.5/components/buttons/" role="button">削除</a></td>
</tr>
<?php
$row = $rs->fetch_assoc ();  
}
?>
</tbody>
</table>

<?php endif; ?>
</div>
</article>
