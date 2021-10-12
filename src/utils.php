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

?>