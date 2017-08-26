<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	if($_POST['idname'] == 'modify'){
/*---------------ユーザー更新---------------*/	
		$sql = "update user_master set 
			name='".form($_POST['name'])."',
			furigana='".form($_POST['furigana'])."',
			sex='".form($_POST['sex'])."',
			tel1='".form($_POST['tel1'])."',
			tel2='".form($_POST['tel2'])."',
			mail1='".form($_POST['mail1'])."',
			mail2='".form($_POST['mail2'])."' where ID=".$_POST['userID'];
			$re=$db->run($sql);


/*---------------ユーザー有りカウンセリングシートのみ登録---------------*/
		if($_POST['counselingID'] == 0){
			$sql="insert into counseling_sheet(user_ID, age, age_etc, major, experience, genre, artist, result, date, time, txt, memo, interviewer, major_category, instructor, skype, advertisement, advertisement_etc, web_portal, search_word, introducer, introducer_name, admission, result_etc) value(
			'".form($_POST['userID'])."',
			'".form($_POST['age'])."',
			'".form($_POST['age_etc'])."',
			'".form($_POST['major'])."',
			'".form($_POST['experience'])."',
			'".form($_POST['genre'])."',
			'".form($_POST['artist'])."',
			'".form($_POST['result'])."',
			'".form($_POST['date'])."',
			'".form($_POST['time'])."',
			'".form($_POST['request'])."',
			'".form($_POST['memo'])."',
			'".form($_POST['interviewer'])."',
			'".form($_POST['major_category'])."',
			'".form($_POST['instructor'])."',
			'".form($_POST['skype'])."',
			'".form($_POST['advertisement'])."',
			'".form($_POST['advertisement_etc'])."',
			'".form($_POST['web_portal'])."',
			'".form($_POST['search_word'])."',
			'".form($_POST['introducer'])."',
			'".form($_POST['introducer_name'])."',
			'".form($_POST['admission'])."',
			'".form($_POST['result_etc'])."')";
			$re=$db->run($sql);

/*---------------検索ワードのみ登録---------------*/
			$sql = "select * from search_word where word='".form($_POST['search_word'])."'";
			$re = $db->run($sql);	
			if($re){
				$sql = "update search_word set search_number=search_number+1 where word='".form($_POST['search_word'])."'";
				$re = $db->run($sql);	
			}else{
				$sql="insert into search_word(word, search_number) value('".form($_POST['search_word'])."', '1')";
				$re = $db->run($sql);	
			}
			
		}else{
/*---------------ユーザー有りカウンセリングシート有りの更新---------------*/	
			$sql = "update counseling_sheet set
			age='".form($_POST['age'])."',
			age_etc='".form($_POST['age_etc'])."',
			major='".form($_POST['major'])."',
			experience='".form($_POST['experience'])."',
			genre='".form($_POST['genre'])."',
			artist='".form($_POST['artist'])."',
			result='".form($_POST['result'])."',
			date='".form($_POST['date'])."',
			time='".form($_POST['time'])."',
			txt='".form($_POST['request'])."',
			memo='".form($_POST['memo'])."',
			interviewer='".form($_POST['interviewer'])."',
			major_category='".form($_POST['major_category'])."',
			instructor='".form($_POST['instructor'])."',
			skype='".form($_POST['skype'])."',
			advertisement='".form($_POST['advertisement'])."',
			advertisement_etc='".form($_POST['advertisement_etc'])."',
			web_portal='".form($_POST['web_portal'])."',
			search_word='".form($_POST['search_word'])."',
			introducer='".form($_POST['introducer'])."',
			introducer_name='".form($_POST['introducer_name'])."',
			admission='".form($_POST['admission'])."',
			result_etc='".form($_POST['result_etc'])."',
			updated=cast( now() as datetime) where ID=".$_POST['counselingID'];
		$re=$db->run($sql);
		
			/*---------------検索ワードのみ登録---------------*/
			//$sql = "select * from search_word where word='千葉　ジャズ'";
			$sql = "update search_word set search_number=search_number-1 where word='".form($_POST['before_word'])."'";
			$re = $db->run($sql);	
			$sql = "delete from search_word where search_number=0 and word='".form($_POST['before_word'])."'";
			$re = $db->run($sql);	
			$sql = "select * from search_word where word='".form($_POST['search_word'])."'";
			$re = $db->run($sql);	
			if($re){
				$sql = "update search_word set search_number=search_number+1 where word='".form($_POST['search_word'])."'";
				$re = $db->run($sql);	
			}else{
				$sql="insert into search_word(word, search_number) value('".form($_POST['search_word'])."', '1')";
				$re = $db->run($sql);	
			}
			
		}
		$data['saveName']  = $_POST['saveName'];

	}else if($_POST['idname'] == 'upload'){


/*---------------新規ユーザー登録---------------*/
		$sql = "insert into user_master(name, furigana, sex, tel1, tel2, mail1, mail2, other, other_, registration_date) value(
			'".form($_POST['name'])."',
			'".form($_POST['furigana'])."',
			'".form($_POST['sex'])."',
			'".form($_POST['tel1'])."',
			'".form($_POST['tel2'])."',
			'".form($_POST['mail1'])."',
			'".form($_POST['mail2'])."',
			'1',
			'1',
			'".date('Y-m-d')."')";
			$re = $db->run($sql);


/*---------------新規カウンセリング登録---------------*/	
		$sql = "select * from user_master where name='".form($_POST['name'])."' and tel1='".form($_POST['tel1'])."' and tel2='".form($_POST['tel2'])."' and mail1='".form($_POST['mail1'])."' and  mail1='".form($_POST['mail1'])."'";
		$re = $db->run($sql);

		$sql="insert into counseling_sheet(user_ID, age, age_etc, major, experience, genre, artist, result, date, time, txt, memo, interviewer, major_category, instructor, skype, advertisement, advertisement_etc, web_portal, search_word, introducer, introducer_name, admission, result_etc) value(
			'".$re[0]['ID']."',
			'".form($_POST['age'])."',
			'".form($_POST['age_etc'])."',
			'".form($_POST['major'])."',
			'".form($_POST['experience'])."',
			'".form($_POST['genre'])."',
			'".form($_POST['artist'])."',
			'".form($_POST['result'])."',
			'".form($_POST['date'])."',
			'".form($_POST['time'])."',
			'".form($_POST['request'])."',
			'".form($_POST['memo'])."',
			'".form($_POST['interviewer'])."',
			'".form($_POST['major_category'])."',
			'".form($_POST['instructor'])."',
			'".form($_POST['skype'])."',
			'".form($_POST['advertisement'])."',
			'".form($_POST['advertisement_etc'])."',
			'".form($_POST['web_portal'])."',
			'".form($_POST['search_word'])."',
			'".form($_POST['introducer'])."',
			'".form($_POST['introducer_name'])."',
			'".form($_POST['admission'])."',
			'".form($_POST['result_etc'])."')";
		$re=$db->run($sql);

/*---------------検索ワードのみ登録---------------*/
			$sql = "select * from search_word where word='".form($_POST['search_word'])."'";
			$re = $db->run($sql);	
			if($re){
				$sql = "update search_word set search_number=search_number+1 where word='".form($_POST['search_word'])."'";
				$re = $db->run($sql);	
			}else{
				$sql="insert into search_word(word, search_number) value('".form($_POST['search_word'])."', '1')";
				$re = $db->run($sql);	
			}

		$data['saveName']  = $_POST['saveName'];
	}

	echo json_encode($data);
?>