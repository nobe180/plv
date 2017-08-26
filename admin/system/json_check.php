<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	$data[] = $_POST['txt'];

	include($_POST['idname'].'/txt.php');
	$data[] = $content_txt;

	// -------  JSON 出力  -------
	echo json_encode($data);
?>