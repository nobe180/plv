<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	
	//admin_check();
	$instructor_ID = $_SESSION['instructor_ID'];
	$instructor_name = $_SESSION['instructor_name'];

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
		$tr .= '<tr><th>'.$time_array1[$i].'　～　'.$time_array2[$i].'</th><td><input type="checkbox" name="time" id="s'.$i.'" value="'.$i.'"><label for="s'.$i.'"></label></td></tr>';
	}
?>
<?php require_once('../header.php'); ?>
<!-- ************* コンテンツ ************* -->


		<link rel="stylesheet" type="text/css" href="index.css" />
		<script type="text/javascript" src="index.js"></script>
		<div id="container">
			<div id="test"></div>
			<input type="hidden" name="instructor_id" value="<?= $instructor_ID ?>" />
			<input type="hidden" name="year_month" value="<?= date('Y-m'); ?>" />
			<h1><?= $instructor_name; ?> <span>レッスンスケジュール登録</span></h1>
			<div class="all_check">
				<input type="radio" name="month_all" id="month_on" value="1"><label for="month_on" class="switch-on">全選択</label>
				<input type="radio" name="month_all" id="month_off" value="0"><label for="month_off" class="switch-off">全解除</label>
			</div>　　
			<input type="button" id="month_register" value="登録" class="btn clearfix">
			<div id="content"><div id="calendar"></div></div>
			<div id="modal">
				<h2></h2>
				<img src="/program/images/material/close.png" id="closeImg" title="閉じる" />
				<div class="all_check">
					<input type="radio" name="all" id="on" value="1"><label for="on" class="switch-on">全選択</label>
					<input type="radio" name="all" id="off" value="0"><label for="off" class="switch-off">全解除</label>
				</div>
				<input type="button" value="登録" class="btn register clearfix">
				<p>レッスン可能な時間帯をクリックしてください。</p>
				<table id="modal_table"><?= $tr; ?></table>
				<div id="set_btn">
					<input type="button" id="cancel" value="キャンセル" class="btn">　
					<input type="button" value="登録" class="btn register">
				</div>
			</div>
		</div>


<!-- ************* ここまで ************* -->
<?php require_once('../footer.php'); ?>
