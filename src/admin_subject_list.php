<?php
// アクセス権限
if (!isset($_SESSION['usr_kind'])){
	die ('<h3>エラー：この機能はログインしないと利用できません</h3>');
}elseif($_SESSION['usr_kind'] != 9 ){
	die ('<h3>エラー：この機能は管理者でないと利用できません</h3>');
}


require_once('db_inc.php');
$sql = <<< EOM
	SELECT * FROM tb_subject WHERE dpt_id = 'RS'
EOM;

$rs = $conn->query($sql);
if(!$rs) die('エラー: '. $conn->error);
$row = $rs->fetch_assoc();
$subjects = [];
while($row){
	$sub_id = $row['sub_id'];
	$subjects[$sub_id] = [
		'sub_name' => $row['sub_name'],
		'dpt_id' => $row['dpt_id'],
		'sub_unit' => $row['sub_unit'],
		'get_year' => $row['get_year'],
		'sub_section' => $row['sub_section']
	];
	$row = $rs->fetch_assoc();
}

?>

<article>

<div class="main">
<h2>登録科目一覧</h2>
<table class="table table-bordered">
<thead class="thead-dark">
<tr>
<th scope="col">科目名</th>
<th scope="col">学科ID</th>
<th scope="col">単位数</th>
<th scope="col">取得学年</th>
<th scope="col">単位区分</th>
<th scope="col">&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach ($subjects as $key => $value) :?>
<tr>
<th scope="row">
<?php
//echo '<a href="https://getbootstrap.com/docs/4.5/content/tables/">';  //1.
echo $value['sub_name'].'</th>';
//echo '</a>';															//2. 2つでリンクをつけられる
echo '<td>'.$value['dpt_id'].'</td>';
echo '<td>'.$value['sub_unit'].'</td>';
$select1 = array(1 => "1年生",
			2 => "2年生",
			3 => "3年生",
			4 => "4年生",);
echo '<td>'.$select1[$value['get_year']].'</td>';
$select2 = array(1 => "必修科目",
			2 => "選択科目",
			3 => "導入科目",
			4 => "教養科目");
echo '<td>'.$select2[$value['sub_section']].'</td>';

?>
<td align="center"><a class="btn btn-secondary btn-sm" href="?do=admin_timetable&sub_id=<?= $key;?>" role="button">時間割登録</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</article>
