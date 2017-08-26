<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	$item = $_POST['item_'];
	$string = form($_POST['string']);
	$refine_id = $_POST['refine_id'];
	$staff_id = $_POST['staff_id'];
	$where = ' where 1';
	if($staff_id != ''){
		$where .= " and ID='".$staff_id."'";
		if($staff_id == '0'){
			$data['new_page'] = '1';
		}else{
			$data['new_page'] = '0';
		}
	}else{
		if($refine_id == 'all'){
			$where .= '';
		}else if($refine_id == 'retirement'){
			$where .= ' and '.$refine_id.'="1"';
		}else{
			$where .= ' and '.$refine_id.'="1" and retirement="0"';
		}
		if($string != ''){
			$string = str_replace("　", " ", $string);//全角空白があったら半角空白にそろえる
			$str_array = preg_split("/[ ]+/",$string);//空白文字で検索ワードを分割	
			foreach($str_array as $str_array_element ){//ワードごとに検索条件を追加
				$where_search = " and concat_ws(char(0), ".$item.") LIKE '%{$str_array_element}%'";
			}
		}
	}
	$sql = "select * from staff".$where.$where_search;
	$data['array'] = $db->run($sql);
	$data['test'] = $sql;

	print json_encode($data);
?>