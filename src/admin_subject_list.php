<?php
// アクセス権限
if (!isset($_SESSION['usr_kind'])){
	die ('<h3>エラー：この機能はログインしないと利用できません</h3>');
}elseif($_SESSION['usr_kind'] != 9 ){
	die ('<h3>エラー：この機能は管理者でないと利用できません</h3>');
}


define('MAX','10');

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

/////////////////////////////////////////////////////////
$subjects_num = count($subjects);
$max_page = ceil($subjects_num / MAX);

if(!isset($_GET['page_id'])){ // $_GET['page_id'] はURLに渡された現在のページ数
    $now = 1; // 設定されてない場合は1ページ目にする
}else{
    $now = $_GET['page_id'];
}

$start_no = ($now - 1) * MAX; // 配列の何番目から取得すればよいか

// array_sliceは、配列の何番目($start_no)から何番目(MAX)まで切り取る関数
$disp_subjects = array_slice($subjects, $start_no, MAX, true);
///////////////////////////////////////////////////////////////
?>

<article>

<div class="main">
<h2>登録科目一覧</h2>
<table class="table table-bordered">
<thead class="thead-dark">
<tr>
<th scope="col" width="25%">科目名</th>
<th scope="col">学科ID</th>
<th scope="col">単位数</th>
<th scope="col">取得学年</th>
<th scope="col">単位区分</th>
<th scope="col">&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach ($disp_subjects as $key => $value) :?>
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
<?php
////////////////////////////////////////////////////////////////////////////////
for($i = 1; $i <= $max_page; $i++){ // 最大ページ数分リンクを作成
    if ($i == $now) { // 現在表示中のページ数の場合はリンクを貼らない
        echo '<p class="nowpage">'.$now. '</p>　';
    } else {
        echo '<a href="?do=admin_subject_list&page_id='. $i. '">'. $i. '</a>'. '　';
    }
}
/////////////////////////////////////////////////////////////////////////////
?>
</div>
</article>
