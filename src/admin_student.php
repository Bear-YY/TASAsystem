<?php 
require_once('db_inc.php');
require_once('data.php');

$sql = "SELECT * FROM tb_student ORDER BY stu_id";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$students = [];
while($row){
	$stu_id = $row['stu_id'];
	$students[$stu_id] = [
		'stu_name' => $row['stu_name'],
		'dpt_id' => $row['dpt_id'],
		'stu_sex' => $row['stu_sex'],
		'stu_mail' => $row['stu_mail'],
		'stu_phoneno' => $row['stu_phoneno']
	];
	$row = $rs->fetch_assoc();
}

?>
<h3>学生一覧</h3>
<table class="table table-bordered">
  <thead class="thead-dark"> 
    <tr>
        <th scope="col">氏名</th>
        <th scope="col">学籍番号</th>
        <th scope="col">学科ID</th>
        <th scope="col">性別</th>
        <th scope="col">メールアドレス</th>
        <th scope="col"></th>
      </tr>
  </thead>  
    <tbody>
    <?php foreach($students as $key => $value): ?>
      <tr>
        <th scope="row"><?= $value['stu_name'] ; ?></td>
        <td><?= $key; ?></td>
        <td><?= $value['dpt_id'] ; ?></td>
        <td><?= $sex[$value['stu_sex']] ; ?></td>
        <td><?= $value['stu_mail'] ; ?></td>
        <td align="center"><a class="btn btn-secondary" href="?do=admin_student_timetable&stu_id=<?= $key; ?>" role="button">応募・推薦時間割</a></td>
      </tr>
  	<?php endforeach; ?>
    </tbody>
</table>