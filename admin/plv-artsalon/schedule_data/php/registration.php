<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	if($_POST['idname'] == 'modify'){
		
/*---------------更新---------------*/
		$start_time = $_POST['start_hour'].':'.$_POST['start_minute'];
		$end_time = $_POST['end_hour'].':'.$_POST['end_minute'];
		$_POST['date'] = str_replace('年', '-', $_POST['date']);
		$_POST['date'] = str_replace('月', '-', $_POST['date']);
		$date = str_replace('日', '', $_POST['date']);
		
		$sql = "update ppc_schedule set 
			department='".$_POST['department']."',
			company='".$_POST['company']."',
			name='".$_POST['name']."',
			sex='".$_POST['sex']."',
			postal='".$_POST['postal']."',
			prefecture='".$_POST['prefecture']."',
			city='".$_POST['city']."',
			address='".$_POST['address']."',
			tel='".$_POST['tel']."',
			mail='".$_POST['mail']."', 
			date_='".$date."',
			start_time='".$start_time."',
			end_time='".$end_time."',
			time_='".$_POST['time_']."',
			price='".$_POST['price']."',
			price_='".$_POST['price_']."',
			title='".$_POST['title']."',
			image='".$_POST['image']."',
			memo='".$_POST['memo']."' where ID='".$_POST['schedule_ID']."'";
		$re = $db->run($sql);
		
		$data['test'] = $sql;
	}else if($_POST['idname'] == 'upload'){

/*---------------新規登録---------------*/
		$start_time = $_POST['start_hour'].':'.$_POST['start_minute'];
		$end_time = $_POST['end_hour'].':'.$_POST['end_minute'];
		$_POST['date'] = str_replace('年', '-', $_POST['date']);
		$_POST['date'] = str_replace('月', '-', $_POST['date']);
		$date = str_replace('日', '', $_POST['date']);
		
		$sql = "insert into ppc_schedule(department, company, name, sex, postal, prefecture, city, address, tel, mail, date_, start_time, end_time, time_, price, price_, title, image, memo, registration_date) value(
			'".$_POST['department']."',
			'".$_POST['company']."',
			'".$_POST['name']."',
			'".$_POST['sex']."',
			'".$_POST['postal']."',
			'".$_POST['prefecture']."',
			'".$_POST['city']."',
			'".$_POST['address']."',
			'".$_POST['tel']."',
			'".$_POST['mail']."',
			'".$date."',
			'".$start_time."',
			'".$end_time."',
			'".$_POST['time_']."',
			'".$_POST['price']."',
			'".$_POST['price_']."',
			'".$_POST['title']."',
			'".$_POST['image']."',
			'".$_POST['memo']."',
			'".date('Y-n-j')."')";
		$re = $db->run($sql);
	
	}else if($_POST['idname'] == 'delete'){
/*---------------削除---------------*/
		$sql = "update ppc_schedule set del=1 where ID='".$_POST['del_ID']."'";
		$re = $db->run($sql);
	}
	
	echo json_encode($data);
?>