<?php 
	
	function flagonCheck($weekday, $timed, $tweekday, $ttimed){
		if(($weekday == $tweekday) && ($timed == $ttimed)){
			return true;
		}
		return false;
	}

	
	function matchdayCheck($schedule,$weekday,$timed, $w, $t){
		if(!empty($schedule)){
			foreach ($schedule as $key => $value) {
				$state = flagonCheck($w ,$t , $value[$weekday], $value[$timed]);
				if($state){
					break;
				}
			}
			if($state){
				return true;
			}
			return false;
		}
		return false;
	}

	function getToday(){
		$date = time();
		$date = date('Y-m-d', $date);
		return $date;
	}

	function listAppsubject($array, $app_result){
		include('data.php');
		foreach($array as $key => $value){ 
        	if(!($value['app_result'] == $app_result)){
        		continue;
        	}
        	echo '<li class="list-group-item">';
        	echo '<a href="?do=student_application&rec_id='.$value['rec_id'].'"><b>'.$value['sub_name']; echo '</b></a><br>';
        	echo '・担当：'.$value['tea_name'].'<br>';
        	echo '・'.$semesters[$value['semester']].'-'.$weekdays_sm[$value['tt_weekday']].'-'.$times[$value['tt_timed']].'<br>';
        	echo '</li>'; 
        }
	}

	function gettotalpointCategoryTT($stu_id, $category_id){
		include('db_inc.php');
		//カテゴリーごとに時間割を取得
		$sql = <<<EOM
		select * from tb_subject natural join tb_timetable natural join tb_category where category_id = '$category_id'
		EOM;
		$rs = $conn->query($sql);
		$row = $rs->fetch_assoc();
		$reccat = [];
		while($row){
			$tt_id = $row['tt_id'];
			$reccat[$tt_id] = [
				'category_name' => $row['category_name'], 
				'category_id' => $row['category_name']		
			];
			$row = $rs->fetch_assoc();
		}
		// var_dump($reccat);
		
		 // || empty($row)

		$scores = [];
		$count = 0;
		foreach ($reccat as $key => $value) {
				//学生のアンケート結果と、募集中の時間割で設定した値を取得
			$sql = <<<EOM
			select * from tb_student natural join tb_answer natural join tb_config natural join tb_recruitment where stu_id = '$stu_id' and tt_id = '$key'
			EOM;
			$rs = $conn->query($sql);
			$row = $rs->fetch_assoc();
			$total = 0;
			
			if(isset($row)){
				while($row){
					$tt_id = $key;
					if($row['con_value'] == 0){
						if($row['ans_value'] < 3){
							$score = 1;
						}
						if($row['ans_value'] == 3){
							$score = 0;
						}
						if($row['ans_value'] > 3){
							$score = -1;
						}
					}else{
						$score = abs($row['con_value'] - $row['ans_value']);
						if($row['con_value'] < $row['ans_value']){
							$score = -$score;
						}
					}
					$total += $score;
					$row = $rs->fetch_assoc();
				}
			}else{
				//アンケート設定を行っていない時間割(募集をかけていない)
				break;
			}
			$scores[$key] = [
				'total' => $total
			];
		}
		// var_dump($scores);
		return $scores;
	}

	function listSide($array, $app_result, $title){
		echo '<div class="card bg-light mb-3" style="width: 12rem;">';
        echo '<div class="card-header">';
        echo $title;
        echo '</div>';
        echo '<ul class="list-group list-group-flush">';
        if($array){
        	listAppsubject($array, $app_result);
        }else{
        	echo 'なし';
        }
        echo '</ul>';
    	echo '</div>';
	}

?>