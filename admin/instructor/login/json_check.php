<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	$id = $_POST['ID'];
	$pass = $_POST['pass'];
//　初期パスワード
//　PLV名_性　＝　MD5に変換
	//$sql="select * from workers where (mail1='".$id."' or mail2='".$id."') and password='".md5($pass)."' and work='継続' and employment='講師'";
	$sql="select * from staff where (mail1='".$id."' or mail2='".$id."') and password1='".md5($pass)."' and instructor='1' and retirement='0'";
	$re = $db->run($sql);
	if($re){
		$_SESSION['instructor_ID'] = $re[0]['ID'];
		$_SESSION['instructor_name'] = str_replace('　', '', $re[0]['name']);
		$data['result'] = 1;
	}else{
		$data['result'] = 0;
	}
	echo json_encode($data);

/*
	$sql = "select * from workers where work='継続' and employment='講師' order by ID ASC";
	$re = $db->run($sql);
	for($i = 0; $i < count($re); $i++){
		$change = str_replace(" ", "_", $re[$i]['english']);
		echo $re[$i]['name'].'　:　'.substr(md5('PLV'.$change),0,8).'<br />';
	}
	//password変換
	//PLV+英語表記の名前をMD5化さらに8文字にする。
	
	$pass = '45d4dd5f';
	echo md5($pass);　//これが初期パスワード
*/
?>
