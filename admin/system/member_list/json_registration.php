<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	if($_POST['idname'] == 'modify'){
		$data['duplicate']  = '0';
		
/*---------------ユーザー更新---------------*/	
		$sql = "update user_master set 
			name='".$_POST['name']."',
			furigana='".$_POST['furigana']."',
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
			school='".$_POST['school']."',
			studio='".$_POST['studio']."',
			repair='".$_POST['repair']."',
			agency='".$_POST['agency']."',
			produce='".$_POST['produce']."', 
			other='".$_POST['other']."', 
			full='".$_POST['full']."',
			associate='".$_POST['associate']."',
			online='".$_POST['online']."',
			studio_='".$_POST['studio_']."',
			withdrawal='".$_POST['withdrawal']."', 
			other_='".$_POST['other_']."', 
			recess='".$_POST['recess']."', 
			memo1='".$_POST['memo1']."', 
			memo2='".$_POST['memo2']."', 
			skype='".$_POST['skype']."', 
			registration_date='".$_POST['registration_date']."', 
			admission_date='".$_POST['admission_date']."', 
			withdrawal_date='".$_POST['withdrawal_date']."', 
			`update`='".date('Y-m-d')."' where ID='".$_POST['user_ID']."'";
		$re = $db->run($sql);

	}else if($_POST['idname'] == 'upload'){
		$data['duplicate']  = '0';
/*---------------新規ユーザー登録---------------*/
		$sql = "select * from user_master where name='".$_POST['name']."' and (concat(char(0), tel1, tel2) LIKE '%{$_POST['tel2']}%') and (concat(char(0), mail1, mail2) LIKE '%{$_POST['mail1']}%')";
		$re = $db->run($sql);
		if(!$re){
			$sql = "insert into user_master(name, furigana, birthdate_Y, birthdate_M, birthdate_D, sex, postal, prefecture, city, address, tel1, tel2, mail1, mail2, school, studio, repair, agency, produce, other, full, associate, online, studio_, withdrawal, other_, recess, memo1, memo2, skype, registration_date, admission_date, withdrawal_date) value(
				'".$_POST['name']."',
				'".$_POST['furigana']."',
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
				'".$_POST['school']."',
				'".$_POST['studio']."',
				'".$_POST['repair']."',
				'".$_POST['agency']."',
				'".$_POST['produce']."',
				'".$_POST['other']."',
				'".$_POST['full']."',
				'".$_POST['associate']."',
				'".$_POST['online']."',
				'".$_POST['studio_']."',
				'".$_POST['withdrawal']."',
				'".$_POST['other_']."',
				'".$_POST['recess']."',
				'".$_POST['memo1']."',
				'".$_POST['memo2']."',
				'".$_POST['skype']."',
				'".$_POST['registration_date']."',
				'".$_POST['admission_date']."',
				'".$_POST['withdrawal_date']."')";
				$re = $db->run($sql);
				
				$sql = "select * from user_master where name='".$_POST['name']."' and (concat(char(0), tel1, tel2) LIKE '%{$_POST['tel2']}%') and (concat(char(0), mail1, mail2) LIKE '%{$_POST['mail1']}%')";
				$re = $db->run($sql);
				$_POST['user_ID'] = $re[0]['ID'];
		}else{
			$data['duplicate']  = '1';
		}
		
	}
	
	
	if($_POST['online'] == '1' || $_POST['online_flag'] == '1'){
//　初期パスワード
//　PLV_名前_入会日　＝　MD5に変換
		$password1 = md5(substr(md5('PLV_'.$_POST['name'].'_'.$_POST['admission_date']),0,8));
		$password2 = md5(substr(md5('PLV_'.$_POST['name'].'_'.$_POST['admission_date']),0,8));
		$password3 = substr(md5('PLV_'.$_POST['name'].'_'.$_POST['admission_date']),0,8);		
		$sql = "select * from online where member_ID='".$_POST['user_ID']."'";
		$re = $db->run($sql);
		if(!$re){
			$sql = "insert into online(member_ID, skype, admission_fee, payment, password1, password2, password3, admission_date, withdrawal) value(
						'".$_POST['user_ID']."',
						'".$_POST['skype']."',
						'0',
						'0',
						'".$password1."',
						'".$password2."',
						'".$password3."',
						'".date('Y-m-d')."', 
						'".$_POST['online_withdrawal']."')";
			$re = $db->run($sql);
		}else{
			$sql = "update online set withdrawal='".$_POST['online_withdrawal']."' where member_ID='".$_POST['user_ID']."'";
			$re = $db->run($sql);
			$data['test']  = $sql;
		}
	}
	
	echo json_encode($data);
?>