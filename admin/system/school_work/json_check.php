<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	$item = $_POST['item_'];
	$string = form($_POST['string']);
	$refine_id = $_POST['refine_id'];
	$counseling_id = $_POST['counseling_id'];
	$pc_sp = $_POST['pc_sp'];
	$period1 = $_POST['period1'];
	$period2 = $_POST['period2'];
	$where = ' where 1';
	$flag = 0;
	if($counseling_id != ''){
		$where .= " and ID='".$counseling_id."'";
		if($counseling_id == '0'){
			$data['new_page'] = '1';
		}else{
			$data['new_page'] = '0';
		}
	}else{
		if($refine_id == '0') $where .= '';
		if($refine_id == '1') $where .= " and result_etc='体験レッスン'";
		if($refine_id == '2') $where .= " and result_etc='カウンセリング'";
		if($refine_id == '3') $where .= " and result_etc='来訪'";
		if($pc_sp == 'all') $where .= "";
		if($pc_sp == 'PC') $where .= " and pc_sp='PC'";
		if($pc_sp == 'SP') $where .= " and pc_sp='SP'";
		if($pc_sp == '') $where .= " and pc_sp=''";
		if($period1 != '' || $period2 != ''){
			$where .= " and admission BETWEEN '".$period1."' AND '".$period2."'";
		}
		if($string != ''){
			$string = str_replace("　", " ", $string);//全角空白があったら半角空白にそろえる
			$str_array = preg_split("/[ ]+/",$string);//空白文字で検索ワードを分割	
			foreach($str_array as $str_array_element ){//ワードごとに検索条件を追加
				$where_search = " and concat_ws(char(0), ".$item.") LIKE '%{$str_array_element}%'";
			}
			if($item != "major"){
				$flag = 1;
			}else{
				$where .= $where_search;
			}
		}
		$data['new_page'] = '0';
	}
	$data['array'] = array();
	$data['user'] = array();
	if($flag != 1){
		/*-----------------　カウンセリングデータ取得　----------------*/
		$sql = "select * from counseling_sheet".$where." and user_ID <> '' order by admission asc";
		$re1 = $db->run($sql);
		/*-----------------　カウンセリングデータ取得　----------------*/
		for($i = 0; $i < count($re1); $i++){
			$data['array'][][]= $re1[$i];
		}
		$data['test'] = $sql;
	}else{
		/*-----------------　ユーザーデータ取得　----------------*/
		$sql = "select * from user_master where 1".$where_search;
		$re1 = $db->run($sql);
		/*-----------------　カウンセリングデータ取得　----------------*/
		for($i = 0; $i < count($re1); $i++){
			$sql = "select * from counseling_sheet".$where." and user_ID='".$re1[$i]['ID']."' order by admission asc";
			$re = $db->run($sql);
			if($re){
				array_push($data['array'], $re);
			}
		}
		
	}

	for($i = 0; $i < count($data['array']); $i++){
		$sql = "select * from user_master where ID='".$data['array'][$i][0]['user_ID']."'";
		$re = $db->run($sql);
		array_push($data['user'], $re);
	}

	$data['test'] = $where;
	
	
	
	print json_encode($data);
?>