<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	require('function.php');

	$data['target_hour'] = $_POST['hour'];
	$data['target_minute'] = $_POST['minute'];
	$data['target_time'] = $_POST['hour'].':'.$_POST['minute'];
	$target_day = date('Y-n-j', strtotime($_POST['target_date'].' +'.$_POST['index'].' day'));
	$data['target_day'] = date('Y年n月j日', strtotime($_POST['target_date'].' +'.$_POST['index'].' day'));
	$data['today'] = date('Y年n月j日');

	$data['flag'] = 0;
	$data['before_schedule'] = 0;
	$data['after_schedule'] = 0;
	$sql = "select * from ppc_schedule where date_='".$target_day."' and start_time < '".$data['target_time']."' order by start_time desc limit 1";
	$re = $db->run($sql);	
	if($re){
		$data['before_schedule'] = $re[0]['end_time'];
	}
	$sql = "select * from ppc_schedule where date_='".$target_day."' and start_time > '".$data['target_time']."' order by start_time asc limit 1";
	$re = $db->run($sql);
	if($re){
		$data['after_schedule'] = $re[0]['start_time'];
	}





	if($_POST['schedule_id'] == '1'){
		$data['page'] = 'modify';
		$sql = "select * from ppc_schedule where ID='".$_POST['data_id']."'";
		$data['schedule'] = $db->run($sql);
		$data['flag'] = 1;
		$data['before_schedule'] = 0;
		$data['after_schedule'] = 0;
		
		$sql = "select * from ppc_schedule where date_='".$data['schedule'][0]['date_']."' and start_time < '".$data['schedule'][0]['start_time']."' order by start_time desc limit 1";
		$re = $db->run($sql);	
		if($re){
			$data['before_schedule'] = $re[0]['end_time'];
		}
		
		$sql = "select * from ppc_schedule where date_='".$data['schedule'][0]['date_']."' and start_time > '".$data['schedule'][0]['start_time']."' order by start_time asc limit 1";
		$re = $db->run($sql);
		if($re){
			$data['after_schedule'] = $re[0]['start_time'];
		}
		
		
	}else{
		$data['page'] = 'new';
	}

//select * from ppc_schedule where date_='2017-03-26' and start_time > '10:00' order by start_time desc
	// -------  JSON 出力  -------
	echo json_encode($data);
?>