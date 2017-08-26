<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	//スケジュール取得
	$sql= "select * from instructor_schedule where instructor_ID='".$_POST['instructor_id']."' and month='".$_POST['year_month']."'";
	$data['my_schedule'] = $db->run($sql);
	$data['day'] = $_POST['day'];


	// -------  JSON 出力  -------
	echo json_encode($data);
?>