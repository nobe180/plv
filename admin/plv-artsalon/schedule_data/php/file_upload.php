<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	$upfile = $_FILES['file']['tmp_name'];
	list($file_name, $file_type) = explode('.',$_FILES['file']['name']);
	$data_imege = date('YmdHis').'.'.$file_type;
	$path = '../upload_file/'.$data_imege;
	move_uploaded_file($upfile, $path);
	echo json_encode($data_imege);
?>