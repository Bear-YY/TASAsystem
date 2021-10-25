
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
<h6>推奨ブラウザ</h6>
<ul>
	<li>GoogleChrome</li>
	<li>Firefox</li>
</ul>
<p>本システムは、TA・SAの募集、応募に関する情報を管理することで<br>
TA・SAを頼みたい教員は募集情報を学生に伝え、学生は気軽に情報を得られるようにします。</p>

<h4><b>教員が利用可能な機能</b></h4>
<ul>
	<li class="listitem"><span class="marker-blue">担当時間割一覧</span>
		<ul>
			<img src="../img/teacher/home_1.png" width="60%" class="img-thumbnail" alt="Responsive image">
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">募集情報登録</span></li>
	<li><span class="marker-blue">応募・推薦者一覧</span>
		<ul>
			<img src="../img/teacher/application_list_1.png" width="60%" class="img-thumbnail" alt="Responsive image">
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">応募・推薦者詳細確認</span></li>
	<li class="listitem"><span class="marker-blue">TA・SA候補者推薦</span></li>
</ul>		

<h4><b>学生が利用可能な機能</b></h4>
<ul>
	<li class="listitem"><span class="marker-blue">募集中時間割の確認</span>
		<ul>
			<img src="../img/student/home_1.png" width="60%" class="img-thumbnail" alt="Responsive image">
			<li>
				<span class="badge badge-success">▼カテゴリー相性：良!!</span>
			：学生の履修科目の成績からカテゴリーごとの成績を算出し、良い成績順に、TA・SA募集中の時間割がお勧めとして表示されます。</li>
			<li>
				<span class="badge badge-success">▼適性相性：良!!</span>
				：アンケート回答をすることによって、相性の良い時間割をお知らせします。

			</li>
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">応募登録機能</span></li>
	<li class="listitem"><span class="marker-blue">スケジュールの登録・削除</span>
		<ul>
			<li>スケジュール登録の登録が行えます。スケジュールが入っていた場合は、応募可能科目の背景が赤色になり、応募出来なくなります。</li>
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">アンケート回答・編集</span>
		<ul>
			<li>アンケートに回答することによって、TA・SAを募集している時間割の中から資質の面で相性の良い科目を知らせてくれます。</li>
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">推薦状態の確認</span>
		<ul>
			<li>推薦が来ていた場合は、サイドバーにお知らせが届きます。</li>
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">推薦の返答</span>
		<ul>
			<li>推薦が来ている時間割に対して教員に、了承するか断るかを選択して応募してください。</li>
		</ul>
	</li>
</ul>		

</div>
<?php 
	}
?>