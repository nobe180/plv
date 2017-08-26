<?php
	require_once($_SERVER[ 'DOCUMENT_ROOT' ] . '/program/php/option.php');
	if($_POST['id']){
		$sql = "select * from information where ID='".$_POST['id']."'";
		$data['data'] = $db->run($sql);
		$data['content'] = nl2br($data['data'][0]['content']);
		// -------  JSON 出力  -------
		echo json_encode($data);
	}
?>
