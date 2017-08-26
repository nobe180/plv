<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');


	if($_POST['sub'] == 1){
		$_SESSION['adminID'] = 1;
	}else{
		$sql="select * from password where password_ID='".$_POST['ID']."' and password_txt='".$_POST['pass']."'";
		$re = $db->run($sql);
		if($re){
			$_SESSION['adminID'] = $re[0]['password_ID'];
			$data = 1;
		}else{
			$data = 0;
		}
	}
	
	echo json_encode($data);
?>