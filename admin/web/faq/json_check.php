<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	if($_POST['index'] == 'add'){
		
		$sql = "insert into faq(flag) value('".$_POST['flag_no']."')";
		$re = $db->run($sql);
		$sql = "select * from faq where flag='".$_POST['flag_no']."' order by ID DESC";
		$re = $db->run($sql);
		$data['new'] = $re[0]['ID'];

	}elseif($_POST['index'] == 'faq_title_add'){
		$sql = "insert into faq(flag) value('".$_POST['new_sort']."')";
		$re = $db->run($sql);
		$sql = "select * from faq where flag='".$_POST['new_sort']."' order by ID DESC";
		$re = $db->run($sql);
		$data['new'] = $re[0]['ID'];
		
	}elseif($_POST['index'] == 'del'){
		$sql = "delete from faq where ID='".$_POST['del_ID']."'";
		$re = $db->run($sql);

	}elseif($_POST['index'] == 'faq_title_del'){
		$sql = "delete from faq where flag='".$_POST['flag']."'";
		$re = $db->run($sql);
	}

	// -------  JSON 出力  -------
	echo json_encode($data);
?>