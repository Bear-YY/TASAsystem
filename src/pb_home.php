
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
	<li class="listitem"><span class="marker-blue">TA・SA募集機能</span>
		<ul>
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">TA・SA推薦機能</span>
		<ul>
		</ul>
	</li>
</ul>

<h4><b>学生が利用可能な機能</b></h4>
<ul>
	<li class="listitem"><span class="marker-blue">アンケート回答機能</span>
		<ul>
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">TA・SA応募機能</span>
		<ul>
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">推薦返答機能</span>
		<ul>
		</ul>
	</li>
</ul>

<h4><b>管理者が利用可能な機能</b></h4>
<ul>
	<li class="listitem"><span class="marker-blue">アンケート登録機能</span>
		<ul>
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">科目登録機能</span>
		<ul>
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">時間割登録機能</span>
		<ul>
		</ul>
	</li>
	<li class="listitem"><span class="marker-blue">応募者採用機能</span>
		<ul>
		</ul>
	</li>
</ul>

</div>
<?php	} ?>
