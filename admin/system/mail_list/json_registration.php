<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	if($_POST['mail_select'] == '1'){
		$sql = "update user_master set mail_delivery='1' where ID='".$_POST['user_ID']."'";
	}else{
		$sql = "update user_master set mail_delivery='0' where ID='".$_POST['user_ID']."'";
	}
	//$data['test'] = $sql;
	$re = $db->run($sql);
	echo json_encode($data);
?>