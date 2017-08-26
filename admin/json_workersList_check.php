<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	$str = form($_POST['searchStr']);
	$id = $_POST['id'];
	$indexID = $_POST['indexID'];
	$where = ' where 1';
	$keizoku = " and work <> '退職'";
	if($indexID != ''){
		$where .= " and ID='".$indexID."'";
	}else{
		if($id == '0') $where .= $keizoku;
		if($id == '1') $where .= $keizoku." and employment='講師'";
		if($id == '2') $where .= $keizoku." and employment='外部'";
		if($id == '3') $where .= $keizoku." and employment='スタッフ'";
		if($id == '4') $where .= " and work='退職予定'";
		if($id == '5') $where .= " and work='退職'";
		if($str != ''){
			//全角空白があったら半角空白にそろえる
			$str = str_replace("　", " ", $str);
			//空白文字で検索ワードを分割	
			$str_array = preg_split("/[ ]+/",$str);
			//ワードごとに検索条件を追加
			foreach($str_array as $str_array_element ){
				$where .= " and concat_ws(char(0),name,furigana,prefecture,city,address,bank,instrument) LIKE '%{$str_array_element}%'";
			}
		}
	}
	$sql = "select * from workers".$where;

	$data['array'] = $db->run($sql);
	$data['index'] = 'staffList';


	print json_encode($data);
?>