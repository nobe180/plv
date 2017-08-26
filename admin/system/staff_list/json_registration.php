<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	if($_POST['idname'] == 'modify'){
/*---------------ユーザー更新---------------*/	
		$sql = "update staff set 
			name='".$_POST['name']."',
			furigana='".$_POST['furigana']."',
			english='".$_POST['english']."',
			birthdate_Y='".$_POST['birthdate_Y']."',
			birthdate_M='".$_POST['birthdate_M']."',
			birthdate_D='".$_POST['birthdate_D']."',
			sex='".$_POST['sex']."',
			postal='".$_POST['postal']."',
			prefecture='".$_POST['prefecture']."',
			city='".$_POST['city']."',
			address='".$_POST['address']."',
			tel1='".$_POST['tel1']."',
			tel2='".$_POST['tel2']."',
			mail1='".$_POST['mail1']."',
			mail2='".$_POST['mail2']."', 
			bank='".$_POST['bank']."',
			branch='".$_POST['branch']."',
			number='".$_POST['number']."', 
			instructor='".$_POST['instructor']."',
			player='".$_POST['player']."', 
			repair='".$_POST['repair']."', 
			staff='".$_POST['staff']."',
			retirement='".$_POST['retirement']."',
			instrument='".$_POST['instrument']."',
			genre='".$_POST['genre']."', 
			my_site='".$_POST['my_site']."',
			memo='".$_POST['memo']."',
			`update`='".date('Y-m-d')."' where ID='".$_POST['staff_ID']."'";
		$re=$db->run($sql);
		$data['saveName']  = $_POST['saveName'];
		//$data['test']  = $sql;

	}else if($_POST['idname'] == 'upload'){


/*---------------新規ユーザー登録---------------*/
		$sql = "insert into staff(name, furigana, english, birthdate_Y, birthdate_M, birthdate_D, sex, postal, prefecture, city, address, tel1, tel2, mail1, mail2, bank, branch, number, instructor, player, repair, staff, retirement, instrument, genre, my_site, memo, admission) value(
			'".$_POST['name']."',
			'".$_POST['furigana']."',
			'".$_POST['english']."',
			'".$_POST['birthdate_Y']."',
			'".$_POST['birthdate_M']."',
			'".$_POST['birthdate_D']."',
			'".$_POST['sex']."',
			'".$_POST['postal']."',
			'".$_POST['prefecture']."',
			'".$_POST['city']."',
			'".$_POST['address']."',
			'".$_POST['tel1']."',
			'".$_POST['tel2']."',
			'".$_POST['mail1']."',
			'".$_POST['mail2']."',
			'".$_POST['bank']."',
			'".$_POST['branch']."',
			'".$_POST['number']."',
			'".$_POST['instructor']."',
			'".$_POST['player']."',
			'".$_POST['	repair']."',
			'".$_POST['staff']."',
			'".$_POST['retirement']."',
			'".$_POST['instrument']."',
			'".$_POST['genre']."',
			'".$_POST['my_site']."',
			'".$_POST['memo']."',
			'".date('Y-m-d')."')";
			$re = $db->run($sql);

		$data['saveName']  = $_POST['saveName'];
		
	}

	echo json_encode($data);
?>