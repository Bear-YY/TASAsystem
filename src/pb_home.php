
<a href="?do=sys_home"></a>
<div class="main">
	
<?php 
	if(isset($_SESSION['usr_kind'])){
		echo 'あなたはusr_kind:'.$_SESSION['usr_kind'].'でログインしています。';
		if($_SESSION['usr_kind'] == 1){
			header('Location:?do=student_home'); 
		}
		if($_SESSION['usr_kind'] == 2){
			header('Location:?do=teacher_home'); 
		}
		if($_SESSION['usr_kind'] == 9){
			header('Location:?do=admin_home'); 
		}
	}else{
		echo '<a href="?do=sys_login"><button type="button" class="btn btn-primary">ログイン</button></a>' ;
		echo '←あなたはログインしていません。ログインを行ってください。<br><br>';
?>

<h2><b>本システムの概要</b></h2>
<p>本システムは、TA・SAの募集、応募に関する情報を管理することで<br>
TA・SAを頼みたい教員は募集情報を学生に伝え、学生は気軽に情報を得られるようにします。</p>

<h4><b>教員が利用可能な機能</b></h4>
<ul>
	<li>募集可能時間割一覧</li>
	<li>募集情報登録</li>
	<li>応募・推薦者一覧</li>
	<li>応募・推薦者詳細確認</li>
	<li>TA・SA候補者推薦</li>
</ul>		

<h4><b>学生が利用可能な機能</b></h4>
<ul>
	<li>募集中時間割の確認
		<ul>
			<li>
				<span class="badge badge-success">▼カテゴリー相性：良!!</span>
			：学生の履修科目の成績からカテゴリーごとの成績を算出し、良い成績順に、TA・SA募集中の時間割がお勧めとして表示されます。</li>
			<li>
				<span class="badge badge-success">▼適性相性：良!!</span>
				：アンケート回答をすることによって、相性の良い時間割をお知らせします。

			</li>
		</ul>
	</li>
	<li>応募登録機能</li>
	<li>スケジュールの登録・削除
		<ul>
		</ul>
	</li>
	<li>アンケート回答・編集</li>
	<li>推薦状態の確認</li>
	<li>推薦の回答</li>
</ul>		

</div>
<?php 
	}
?>