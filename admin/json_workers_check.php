<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	$ID = $_POST['id'];
	$TXT = $_POST['txt'];
	$data['contentName'] = 'workers';

	if($_POST['idname'] == 'modify'){
		$sql = "update workers set
		work='".form($_POST['work'])."', 
		employment='".form($_POST['employment'])."', 
		name='".form($_POST['name'])."', 
		english='".form($_POST['english'])."',
		furigana='".form($_POST['furigana'])."', 
		postal='".form($_POST['postal'])."', 
		prefecture='".form($_POST['prefecture'])."', 
		city='".form($_POST['city'])."', 
		address='".form($_POST['address'])."', 
		tel='".form($_POST['tel'])."', 
		mobile='".form($_POST['mobile'])."', 
		mail1='".form($_POST['mail1'])."', 
		mail2='".form($_POST['mail2'])."', 
		bank='".form($_POST['bank'])."', 
		branch='".form($_POST['branch'])."', 
		number='".form($_POST['number'])."',
		instrument='".form($_POST['instrument'])."',
		genre='".form($_POST['genre'])."',
		website='".form($_POST['website'])."',
		profile='".form($_POST['profile'])."',
		major='".form($_POST['major'])."',
		specialty_genre='".form($_POST['specialty_genre'])."',
		responsible='".form($_POST['responsible'])."',
		educational='".form($_POST['educational'])."',
		image='".form($_POST['image'])."',
		catchphrase='".form($_POST['catchphrase'])."',
		keywords='".form($_POST['keywords'])."',
		description='".form($_POST['description'])."',
		comment='".form($_POST['comment'])."',
		license='".form($_POST['license'])."',
		product='".form($_POST['product'])."',
		demo='".$_POST['demo']."',
		course='".form($_POST['course'])."',
		days='".form($_POST['days'])."',
		tag='".form($_POST['major_category'])."' where ID=".$ID;
		$re=$db->run($sql);
		for($i = 0; $i < $_POST['textareaNum']; $i++){
			$sql = "select * from course where ID='".$_POST['course_id'.($i+1)]."'";
			$re = $db->run($sql);
			if($re){
				$sql = "update course set
				about='".form($_POST['about'.($i+1)])."', 
				name='".form($_POST['name'.($i+1)])."',
				minute='".form($_POST['minute'.($i+1)])."',
				num='".form($_POST['num'.($i+1)])."',
				price='".form($_POST['price'.($i+1)])."',
				detail='".form($_POST['detail'.($i+1)])."' where ID=".$_POST['course_id'.($i+1)];
				$re = $db->run($sql);
			}else{
				$sql="insert into course(instructor, type, about, name, minute, num, price, detail) value(
				'".$ID."',
				'1',
				'".form($_POST['about'.($i+1)])."',
				'".form($_POST['name'.($i+1)])."',
				'".form($_POST['minute'.($i+1)])."',
				'".form($_POST['num'.($i+1)])."',
				'".form($_POST['price'.($i+1)])."',
				'".form($_POST['detail'.($i+1)])."')";
				$re = $db->run($sql);
			}
			if($_POST['delete'.($i+1)] == 1){
				$sql = "update course set instructor='', type='', about='', name='', minute='', num='', price='', detail='' where ID=".$_POST['course_id'.($i+1)];
				$re = $db->run($sql);
			}
		}
		
		
		
		
		
		$data['completion'] = 1;
		$data['selectID'] = $ID;

	}else if($_POST['idname'] == 'newSave'){
		$sql="insert into workers(
		english,
		furigana,
		name,
		postal,
		prefecture,
		city,
		address,
		tel,
		mobile,
		mail1,
		mail2,
		bank,
		branch,
		number,
		work,
		employment,
		instrument,
		genre,
		website,
		profile,
		major,
		specialty_genre,
		responsible,
		educational,
		image,
		catchphrase,
		keywords,
		description,
		comment,
		license,
		product,
		course) value(
		'".form($_POST['english'])."',
		'".form($_POST['furigana'])."',
		'".form($_POST['name'])."',
		'".form($_POST['postal'])."',
		'".form($_POST['prefecture'])."',
		'".form($_POST['city'])."',
		'".form($_POST['address'])."',
		'".form($_POST['tel'])."',
		'".form($_POST['mobile'])."',
		'".form($_POST['mail1'])."',
		'".form($_POST['mail2'])."',
		'".form($_POST['bank'])."',
		'".form($_POST['branch'])."',
		'".form($_POST['number'])."',
		'".form($_POST['work'])."',
		'".form($_POST['employment'])."',
		'".form($_POST['instrument'])."',
		'".form($_POST['genre'])."',
		'".form($_POST['website'])."',
		'".form($_POST['profile'])."',
		'".form($_POST['major'])."',
		'".form($_POST['specialty_genre'])."',
		'".form($_POST['responsible'])."',
		'".form($_POST['educational'])."',
		'".form($_POST['image'])."',
		'".form($_POST['catchphrase'])."',
		'".form($_POST['keywords'])."',
		'".form($_POST['description'])."',
		'".form($_POST['comment'])."',
		'".form($_POST['license'])."',
		'".form($_POST['product'])."',
		'".form($_POST['course'])."')";
		$re=$db->run($sql);
		$data['completion'] = 1;


	}else{
		//データベースの何行目に存在しているかのチェック
		$sql = "select T1.ID, COUNT(T2.ID) as bangou from workers as T1, workers as T2 where T1.ID='".$ID."' and T1.ID >= T2.ID group by T1.ID";
		$re = $db->run($sql);
		$nowNumber = $re[0]['bangou']-1;

		$sql = "select * from workers order by ID ASC";
		$re = $db->run($sql);
		$data = array();
		$data[0] = 0;
		if($TXT == 'prevBtn') $ChangeNumber = $nowNumber-1;
		else if($TXT == 'nextBtn') $ChangeNumber = $nowNumber+1;
		else if($TXT == 'listSelect') $ChangeNumber = $nowNumber;

		if($ChangeNumber == $data[0]) $data[0] = 1;
		else if($ChangeNumber == (count($re)-1)) $data[0] = 2;

		$data[1] = $re[$ChangeNumber]['ID'];
		$data[2] = $ChangeNumber;
		$data[3] = $re;
		$data[4] = count($re);




		$courseAry = array('アカデミック', 'ピンポイント', '集中講座', 'オンライン', 'グループ', 'イベント');
		for($i = 0; $i < count($courseAry); $i++){
			if (strstr($re[$ChangeNumber]['course'], $courseAry[$i])){
					$courseSelect .= '<label><input type="checkbox" name="course" class="check course'.$i.'" value="'.$courseAry[$i].'" checked="checked" />'.$courseAry[$i].'</label>　　';
				}else{$courseSelect .= '<label><input type="checkbox" name="course" class="check course'.$i.'" value="'.$courseAry[$i].'" />'.$courseAry[$i].'</label>　　';}
		}
		$daysAry = array('日曜', '火曜', '水曜', '木曜', '金曜', '土曜', '不定期');
		for($i = 0; $i < count($daysAry); $i++){
			if (strstr($re[$ChangeNumber]['course'], $daysAry[$i])){
					$daysSelect .= '<label><input type="checkbox" name="days" class="check days'.$i.'" value="'.$daysAry[$i].'" checked="checked" />'.$daysAry[$i].'</label>　　';
				}else{$daysSelect .= '<label><input type="checkbox" name="days" class="check days'.$i.'" value="'.$daysAry[$i].'" />'.$daysAry[$i].'</label>　　';}
		}
		$sql = "select * from plv_option";
		$op = $db->run($sql);
		$major_category = explode(',', $op[0]['major']);
		for($i = 0; $i < count($major_category); $i++){
			if (strstr($re[$ChangeNumber]['tag'], $major_category[$i])){
					$majorSelect .= '<label><input type="checkbox" name="major_category" class="check days'.$i.'" value="'.$major_category[$i].'" checked="checked" />'.$major_category[$i].'</label>　　';
				}else{$majorSelect .= '<label><input type="checkbox" name="major_category" class="check days'.$i.'" value="'.$major_category[$i].'" />'.$major_category[$i].'</label>　　';}
		}
		
		
		$sql = "select * from course where instructor='".$data[1]."' order by ID asc";//コースが存在するかチェック
		$re1 = $db->run($sql);
		if($re1){

			for($i = 0; $i < count($re1); $i++){
				
					$text .= '<tr>
									<th rowspan="2" class="coruseTh1">'.($i+1).'</th><th class="coruseTh1"></th><td><input type="text" class="course_name" name="about'.($i+1).'" value="'.$re1[$i]['about'].'" /></td>
									<th>コース名</th><td><input type="text" class="course_name" name="name'.($i+1).'" value="'.$re1[$i]['name'].'" /></td>
									<th>時間</th><td class="coruseTh2"><input type="text" class="course_ipt" name="minute'.($i+1).'" value="'.$re1[$i]['minute'].'" /></td>
									<th>回数</th><td class="coruseTh2"><input type="text" class="course_ipt" name="num'.($i+1).'" value="'.$re1[$i]['num'].'" /></td>
									<th>料金（税込）</th><td class="coruseTh2"><input type="text" class="course_ipt" name="price'.($i+1).'" value="'.$re1[$i]['price'].'" /></td>
								</tr>
								<tr class="course_delete"><th class="coruseTh1">説明</th><td colspan="9" class="coruseTd"><textarea class="course_detail" name="detail'.($i+1).'">'.$re1[$i]['detail'].'</textarea><input type="hidden" name="course_id'.($i+1).'" value="'.$re1[$i]['ID'].'" />
			<input type="checkbox" class="check" id="dell_check'.($i+1).'" name="delete'.($i+1).'" value="1" /><label for="dell_check'.($i+1).'">削除</label>
			</td></tr>';
				}
			
			$course = '<div class="courseType">【 アカデミック 】<span class="add">＋</span></div><table class="courseTable academic">'.$text.'</table>';
		}
		
		$data[5] = '<table class="workersTable">
						<tr><th>メタワード</th><td class="keywordsTd"><textarea name="keywords">'.$re[$ChangeNumber]['keywords'].'</textarea></td></tr>
						<tr><th>メタデスクリプション</th><td class="descriptionTd"><textarea name="description">'.$re[$ChangeNumber]['description'].'</textarea></td></tr>
						<tr><th>担当名</th><td><input type="text" name="responsible" value="'.$re[$ChangeNumber]['responsible'].'" /></td></tr>
						<tr><th>担当科目</th><td class="majorTd"><textarea name="major">'.$re[$ChangeNumber]['major'].'</textarea></td></tr>
						<tr><th>得意ジャンル</th><td class="specialty_genreTd"><textarea name="specialty_genre">'.$re[$ChangeNumber]['specialty_genre'].'</textarea></td></tr>
						<tr><th>学歴</th><td class="educationalTd"><textarea name="educational">'.$re[$ChangeNumber]['educational'].'</textarea></td></tr>
						<tr><th>キャッチフレーズ</th><td class="catchphraseTd"><textarea name="catchphrase">'.$re[$ChangeNumber]['catchphrase'].'</textarea></td></tr>
						<tr><th>プロフィール画像</th><td><input type="text" name="image" value="'.$re[$ChangeNumber]['image'].'" /></td></tr>
						<tr><th>プロフィール</th><td class="profileTd"><textarea name="profile">'.$re[$ChangeNumber]['profile'].'</textarea></td></tr>
						<tr><th>一言</th><td class="commentTd"><textarea name="comment">'.$re[$ChangeNumber]['comment'].'</textarea></td></tr>
						<tr><th>資格</th><td class="licenseTd"><textarea name="license">'.$re[$ChangeNumber]['license'].'</textarea></td></tr>
						<tr><th>作品</th><td class="productTd"><textarea name="product">'.$re[$ChangeNumber]['product'].'</textarea></td></tr>
						<tr><th>デモ</th><td class="demoTd"><textarea name="demo">'.$re[$ChangeNumber]['demo'].'</textarea></td></tr>
					</table>

					<table class="workersTable">
						<tr><th></th><td id="majorCategory">　'.$majorSelect.'</td></tr>
						<tr><th>コース</th><td id="course">　'.$courseSelect.'</td></tr>
						<tr><th>曜日</th><td id="days">　'.$daysSelect.'</td></tr>
					</table>'
					.$course;
	}

	$data['flag'] = 0;
	if($TXT == 'new'){
		$data['flag'] = 1;
		$data['date'] = date("Y-m-d");
	}

	echo json_encode($data);

?>