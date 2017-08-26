<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	if(isset($_POST['update'])){
		$sql="insert into information(title, date, flag, `show`, content) value('".$_POST['title']."','".$_POST['date']."','".$_POST['select']."', '".$_POST['show']."','".$_POST['content']."')";
		$re=$db->run($sql);
		url('../?ID='.$_POST['select']);
	}
?>


