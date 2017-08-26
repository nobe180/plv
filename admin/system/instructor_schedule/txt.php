<?php
	$sql="select * from staff where instructor='1' and retirement='0'";
	$re = $db->run($sql);
	for($i = 0; $i < count($re); $i++){
		$valueOption .= '<option value="'.$re[$i]['ID'].'">'.$re[$i]['name'].'</option>';
	}

	$time_array1 = array();
	$time_array2 = array('11:30');
	for($i = 11; $i <= 22; $i++){
		for($v = 0; $v <= 3; $v += 3){
			array_push($time_array1, $i.':'.$v.'0');
		}
	}
 
	for($i = 12; $i <= 22; $i++){
		for($t = 0; $t <= 3; $t += 3){
			array_push($time_array2, $i.':'.$t.'0');
		}
	}
	for($i = 0; $i < count($time_array1)-2; $i++){
		$tr .= '<tr><td>'.$time_array1[$i].'　～　'.$time_array2[$i].'</td></tr>';
	}


	$content_txt = '
		<link rel="stylesheet" type="text/css" href="/program/javascript/fullcalendar/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="/program/javascript/fullcalendar/fullcalendar.min.css" />
		<link rel="stylesheet" type="text/css" href="/admin/system/instructor_schedule/index.css" />
		<script type="text/javascript" src="/program/javascript/fullcalendar/moment.min.js"></script>
		<script type="text/javascript" src="/program/javascript/fullcalendar/fullcalendar.min.js"></script>
		<script type="text/javascript" src="/program/javascript/fullcalendar/ja.js"></script>
		<script type="text/javascript" src="/admin/system/instructor_schedule/index.js"></script>
		<input type="hidden" name="year_month" value="'.date('Y-m').'" />
		<select class="selector" name="instructor_id" size="4">'.$valueOption.'</select>
		<div id="content"><div id="calendar"></div></div>
		<div id="modal">
			<p id="instructor_name"></p>
			<h2></h2>
			<img src="/program/images/material/close.png" id="closeImg" title="閉じる" />
			<table id="modal_table">'.$tr.'</table>
			<input type="button" id="cancel" value="閉じる" class="btn">
		</div>';
?>