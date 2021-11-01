<?php 
require_once('db_inc.php');
require_once('data.php');

$sql = "SELECT * FROM tb_teacher ORDER BY tea_id";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$teachers = [];
while($row){
	$tea_id = $row['tea_id'];
	$teachers[$tea_id] = [
		'tea_name' => $row['tea_name'],
		'dpt_id' => $row['dpt_id'],
		'tea_sex' => $row['tea_sex'],
		'tea_room' => $row['tea_room'],
		'tea_mail' => $row['tea_mail'],
		'tea_phoneno' => $row['tea_phoneno']
	];
	$row = $rs->fetch_assoc();
}

?>
<h3>教員一覧</h3>
<table class="table table-bordered">
  <thead class="thead-dark"> 
    <tr>
        <th scope="col">氏名</th>
        <th scope="col">教員ID</th>
        <th scope="col">学科ID</th>
        <th scope="col">性別</th>
        <th scope="col">教室番号</th>
        <th scope="col">メールアドレス</th>
        <th scope="col"></th>
      </tr>
  </thead>  
    <tbody>
    <?php foreach($teachers as $key => $value): ?>
      <tr>
        <td><?= $value['tea_name'] ; ?></td>
        <td><?= $key; ?></td>
        <td><?= $value['dpt_id'] ; ?></td>
        <td><?= $sex[$value['tea_sex']] ; ?></td>
        <td><?= $value['tea_room'] ; ?></td>
        <td><?= $value['tea_mail'] ; ?></td>
        <td align="center"><a class="btn btn-secondary" href="?do=admin_teacher_timetable&tea_id=<?= $key; ?>" role="button">担当時間割</a></td>
      </tr>
  	<?php endforeach; ?>
    </tbody>
</table>