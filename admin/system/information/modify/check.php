<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	$id = $_POST['id'];
	if(isset($_POST['modify'])){
		$sql = "update information set 
						title='".$_POST['title']."', 
						date='".$_POST['date']."', 
						flag='".$_POST['select']."',
						`show`='".$_POST['show']."', 
						content='".$_POST['content']."' where ID='".$id."'";
		$re = $db->run($sql);
		
		$_SESSION['test'] = $sql;
		
		url('../?ID='.$_POST['select']);
	}

	if(isset($_POST['delete'])){
		$sql="update information set del=1 where ID='".$id."'";
		$re=$db->run($sql);
		url('../');
	}
?>