<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	$sql="select * from staff where ID='".$_POST['instructor_id']."' and password1='".md5($_POST['pass_now'])."'";
	$re =$db->run($sql);
	$flag = 0;
	if(!$re){
		$flag = 1;
	}else{
		if($_POST['pass_new'] != $_POST['pass_new_confirm']){
			$flag = 2;
		}else{
			$sql = "update staff set password1='". md5($_POST['pass_new'])."' where ID='".$_POST['instructor_id']."'";
			$re = $db->run($sql);
		}
	}
	$data['index'] = $flag;
	// -------  JSON 出力  -------
	echo json_encode($data);
?>