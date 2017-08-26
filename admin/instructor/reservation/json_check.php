<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	if($_POST['index'] == 'update'){
		//スケジュール更新
		$sql = "update instructor_schedule set `".$_POST['day']."`='".$_POST['time_records']."' where instructor_ID='".$_POST['instructor_id']."' and month='".$_POST['year_month']."'";
		$re = $db->run($sql);
		//$data['test'] = $sql;
		
	}elseif($_POST['index'] == 'register'){
		//新規登録
			$sql = "insert into instructor_schedule(instructor_ID, month, `".$_POST['day']."`) value(
			'".$_POST['instructor_id']."',
			'".$_POST['year_month']."',
			'".$_POST['time_records']."')";
			$re = $db->run($sql);
	}elseif($_POST['index'] == 'all'){
		//新規登録
			$sql = "select * from instructor_schedule where instructor_ID='".$_POST['instructor_id']."' and month='".$_POST['year_month']."'";
			$re = $db->run($sql);
			$default_day = $_POST['default_day'];
			$array = explode('、', $_POST['day']);
			if($re){//存在する場合
				if($_POST['month_all'] == 1){		
					for($i = 1; $i <= 28; $i++){
						$change_day = $default_day;
						if(strstr($re[0][$i], '_')){
							$time_array = explode(',', $re[0][$i]);
							for($v = 0; $v < count($time_array); $v++){
								if(strstr($time_array[$v], '_')) {
									$change = str_replace('_', '', $time_array[$v]);
									$change_day = str_replace(','.$change, ','.$change.'_', $change_day);
								}
							}
						}
						$where .= " `".$i."`='".$change_day."',"; 
					}
				}else{
					for($i = 1; $i <= 28; $i++){
						$change_day = $re[0][$i];
						if(strstr($re[0][$i], '_')){
							$time_array = explode(',', $re[0][$i]);
							$change_day = '';
							for($v = 0; $v < count($time_array); $v++){
								if(strstr($time_array[$v], '_')) {
									$change_day .= $time_array[$v].',';
								}
							}
							$change_day = substr($change_day, 0, -1);
						}else{
							$change_day = '';
						}
						$where .= " `".$i."`='".$change_day."',"; 
					}
				}
				$where = substr($where, 0, -1);
				$sql = "update instructor_schedule set".$where." where instructor_ID='".$_POST['instructor_id']."' and month='".$_POST['year_month']."'";
				$re = $db->run($sql);


			}else{//存在しない場合
				$sql = "insert into instructor_schedule(instructor_ID, month, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`) value(
			'".$_POST['instructor_id']."', '".$_POST['year_month']."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."', '".$default_day."')";
				$re = $db->run($sql);
				$data['test'] = $sql;
			}
			
			$sql = "update instructor_schedule set `".$array[0]."`='', `".$array[1]."`='', `".$array[2]."`='', `".$array[3]."`='' where instructor_ID='".$_POST['instructor_id']."' and month='".$_POST['year_month']."'";
			$re = $db->run($sql);
			$data['year_month'] = $_POST['year_month'];	
			
			
	}else{
		//スケジュール取得
		$sql = "select * from instructor_schedule where instructor_ID='".$_POST['instructor_id']."' and month='".$_POST['year_month']."'";
		$data['my_schedule'] = $db->run($sql);
		
		
		$lesson_day = $_POST['year_month'].'-'.$_POST['day'];
		$sql = "select * from online_schedule where instructor_ID='".$_POST['instructor_id']."' and date_='".$lesson_day."' order by time_ ASC";
		$re = $db->run($sql);
		$data['test'] = $sql.'<br />';
		if($re){
			$data['lesson_member'] = '';
			for($i = 0; $i < count($re); $i++){
				$sql = "select * from user_master where ID='".$re[$i]['user_ID']."'";
				$re2 = $db->run($sql);
				//$data['test'] .= $sql.'<br />';
				$data['lesson_member'][] = $re2[0]['name'];
			}
		}else{
			$data['lesson_member'] = '';
		}
		
		
	
		
		
		
		
		$data['index'] = 'register';
		if($data['my_schedule']){
			$data['index'] = 'update';
		}
		$data['day'] = $_POST['day'];
	}

	// -------  JSON 出力  -------
	echo json_encode($data);
?>