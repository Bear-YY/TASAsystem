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

if($students){
  foreach ($students as $key => $value) {
    //応募数を$studentsに加える。
    $sql = <<<EOM
      SELECT *,COUNT(*) AS apptotal FROM tb_application NATURAL JOIN tb_recruitment rec NATURAL JOIN tb_teacher, tb_timetable tt NATURAL JOIN tb_subject
      WHERE app_id IN
        (SELECT app_id
        FROM tb_application
        WHERE stu_id = '{$key}')
      AND rec.tt_id = tt.tt_id
    EOM;
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    $students[$key]['apptotal'] = $row['apptotal'];

    //推薦数を$studentsに加える
    $sql = <<<EOM
      SELECT *,COUNT(*) AS rcmtotal FROM tb_recommend NATURAL JOIN tb_recruitment rec NATURAL JOIN tb_teacher, tb_timetable tt NATURAL JOIN tb_subject
      WHERE rcm_id IN
        (SELECT rcm_id
        FROM tb_recommend
        WHERE stu_id = '{$key}')
      AND rec.tt_id = tt.tt_id
    EOM;
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    $students[$key]['rcmtotal'] = $row['rcmtotal'];
  }
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
        <th scope="col">応募数</th>
        <th scope="col">推薦数</th>
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
				<?php if($value['apptotal'] == 0): ?>
					<td>
				<?php else: ?>
					<td class="table-primary">
				<?php endif; ?>
				<?= $value['apptotal'] ; ?></td>

				<?php if($value['rcmtotal'] == 0): ?>
					<td>
				<?php else: ?>
					<td class="table-warning">
				<?php endif; ?>
        <?= $value['rcmtotal'] ; ?></td>
        <td align="center"><a class="btn btn-secondary" href="?do=admin_student_timetable&stu_id=<?= $key; ?>" role="button">応募・推薦時間割</a></td>
      </tr>
  	<?php endforeach; ?>
    </tbody>
</table>
