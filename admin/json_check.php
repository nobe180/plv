<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	$data[] = $_POST['txt'];

	// -------  オンライン用講師スケジュール登録表示  -------
	if($_POST['idname']=="onlineSchedule"){
		include('instructor_schedule/schedule_txt.php');
		$data[] = $content_txt;
	}
	
	// ------- オンライン用予約・支払状況表示  -------
	if($_POST['idname']=="onlinePayment"){
		include('online_payment/payment_txt.php');
		$data[] = $content_txt;
	}


	// ------- オンライン用予約・支払状況表示  -------
	if($_POST['idname']=="dispatch_estimate"){
		include('dispatch_estimate/estimate_txt.php');
		$data[] = $content_txt;
	}


	// -------  PLV音楽院業務表示  -------
	if($_POST['idname']=="schoolWork"){
		include('school_work/txt.php');
		$data[] = $content_txt;
	}


	// -------  MIDI検定4級試験用パスワード表示  -------
	if($_POST['idname']=="midiPass"){
		$fun=substr(date('i'),0,1);
		$midiTxt='<p>MIDI検定4級試験のパスワードは <span style="font-size:1.2em;color:#f00000;">'.substr(md5('PLV'.date('ynjH').$fun),0,8).'</span> です。</p>
<p class="notice">10分置きにパスワードが変更します。</p>';
		$data[]=$midiTxt;
	}

	// -------  MIDI検定4級用初期表示  -------
	else if($_POST['idname']=="midiLicense"){
		$sql = "select * from midi_licence order by midi_ID DESC";
		$re1 = $db->run($sql);

		$sql = "select * from online where online_ID='".$re1[0]['midi_U_ID']."'";
		$re2=$db->run($sql);

		for($i = 0;$i<count($re1);$i++){
			$optionVal.='<option value="'.$re1[$i]['midi_ID'].'">'.$re1[$i]['midi_U_name'].'</option>';				
		}

		$date = $re1[0]['midi_date'];

		$mobile = $re2[0]['online_mobile'].'（携帯）';
		$telephone = $re2[0]['online_tel'].'（自宅）';
		if($re2[0]['online_mobile'] == '') $mobile = '';
		if($re2[0]['online_tel'] == '') $telephone = '';

		function answer($a, $b, $c, $d){
			$db = new db("mysql:host=".SYS_DBHOST.";dbname=".SYS_DBNAME.";charset=utf8",SYS_DBUSER,SYS_DBPW);
			$sql = "select * from midi_licence order by midi_ID DESC";
			$re = $db->run($sql);
			$abc = array('','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o');
			$answer = array('',1,3,1,4,1,3,2,1,1,2,3,1, 1,4,2,1,1,2,1,2,5,3,1,5,3, 2,3,1,2,1,3,2, 2,2,4,2,1,3,1,3,2,5,1,1,4,2,3, 1,3,1);
			$aa = $d;
			$total = 0;
			for($i = $a; $i <= $b; $i++){
				if($answer[$aa] != $re[0][$c.$abc[$i]]){
					$answerData .= '<td class="incorrect">'.$re[0][$c.$abc[$i]].'</td>';
				}else{
					$answerData .= '<td>'.$re[0][$c.$abc[$i]].'</td>';
					$total += 2;
				}
				$aa ++;
			}
			return array($answerData, $total);
		}
		list($q1_1, $q1_1b) = answer(1, 6, 1, 1);
		list($q1_2, $q1_2b) = answer(7, 12, 1, 7);
		list($q2_1, $q2_1b) = answer(1, 7, 2, 13);
		list($q2_2, $q2_2b) = answer(8, 13, 2, 20);
		list($q3, $q3b) = answer(1, 7, 3, 26);
		list($q4_1, $q4_1b) = answer(1, 8, 4, 33);
		list($q4_2, $q4_2b) = answer(9, 15, 4, 41);
		list($q5, $q5b) = answer(1, 3, 5, 48);

		$total = $q1_1b+$q1_2b+$q2_1b+$q2_2b+$q3b+$q4_1b+$q4_2b+$q5b;

		$midiTxt='<p id="midi">2015 年度MIDI検定4級　試験問題　　　　　　　（試験時間 : 30分　参照不可　1問2点　計50問）</p>
			<input type="hidden" id="midiId" value="'.$re1[0]['midi_ID'].'" />
			<div id="grading"><span>'.$total.'</span>　点</div>
			<table id="student_name" width="60%">
				<tr><th width="25%">フリガナ</th><td><span id="student1">'.$re2[0]['online_furigana'].'</span></td></tr>
				<tr><th>氏名</th><td><span id="student2">'.$re2[0]['online_name'].'</span></td></tr>
			</table>
			<table id="student1" width="100%">

				<tr>
					<td width="65%">
						生年月日　:　<span id="student3">'.$re2[0]['online_birthdate_Y'].'</span>　　年　　
						<span id="student4">'.$re2[0]['online_birthdate_M'].'</span>　　月　　
						<span id="student5">'.$re2[0]['online_birthdate_D'].'</span>　　日
					</td>
					<th width="0%">&nbsp;</th><td>性別　:　<span id="student6">'.$re2[0]['online_sex'].'</span></td>
				</tr>

				<tr>
					<td>
						実施日付　:　<span id="midi1">'.date('Y', strtotime($date)).'</span>　　年　　
						<span id="midi2">'.date('n', strtotime($date)).'</span>　　月　　
						<span id="midi3">'.date('j', strtotime($date)).'</span>　　日
					</td>
					<th>&nbsp;</th>
					<td>職業または学校名　:　</td>
				</tr>

			</table>

			<table id="student2" width="100%">

				<tr>
					<td colspan="2">
						住所　:　〒<span id="student7">'.$re2[0]['online_postal'].'</span>　
						<span id="student8">'.$re2[0]['online_prefecture'].'</span> 
						<span id="student9">'.$re2[0]['online_city'].'</span> 
						<span id="student10">'.$re2[0]['online_address'].'</span>
					</td>
				</tr>

				<tr><td width="70%">電話　:　<span id="tel">'.$telephone.$mobile.'</span></td><th>&nbsp;</th></tr>

				<tr><td>実施場所　:　PLV music network（オンライン）</td><th></th></tr>

			</table>
			<table class="midi_q">
				<tr><th rowspan="4">第1章</th><th>a</th><th>b</th><th>c</th><th>d</th><th>e</th><th>f</th></tr>
				<tr id="q1_1">'.$q1_1.'</tr>
				<tr><th>g</th><th>h</th><th>i</th><th>j</th><th>k</th><th>l</th></tr>
				<tr id="q1_2">'.$q1_2.'</tr>
			</table>

			<table  class="midi_q">
				<tr><th rowspan="4">第2章</th><th>a</th><th>b</th><th>c</th><th>d</th><th>e</th><th>f</th><th>g</th></tr>
				<tr id="q2_1">'.$q2_1.'</tr>
				<tr><th>h</th><th>i</th><th>j</th><th>k</th><th>l</th><th>m</th></tr>
				<tr id="q2_2">'.$q2_2.'</tr>
			</table>

			<table  class="midi_q">
				<tr><th rowspan="2">第3章</th><th>a</th><th>b</th><th>c</th><th>d</th><th>e</th><th>f</th><th>g</th></tr>
				<tr id="q3">'.$q3.'</tr>
			</table>

			<table  class="midi_q">
				<tr><th rowspan="4">第4章</th><th>a</th><th>b</th><th>c</th><th>d</th><th>e</th><th>f</th><th>g</th><th>h</th></tr>
				<tr id="q4_1">'.$q4_1.'</tr>
				<tr><th>i</th><th>j</th><th>k</th><th>l</th><th>m</th><th>n</th><th>o</th></tr>
				<tr id="q4_2">'.$q4_2.'</tr>
			</table>

			<table  class="midi_q">
				<tr><th rowspan="2">第5・6章</th><th>a</th><th>b</th><th>c</th></tr>
				<tr id="q5">'.$q5.'</tr>
			</table>
			<div id="midiLicense" class="controll clearfix">
				<input type="button" id="print" value="このページを印刷" onclick="window.print();" class="btn" />
				<div id="select"><select id="listSelect" name="list">'.$optionVal.'</select></div>
				<div id="prev" class="controllBtn left"><input type="button" id="prevBtn" value="前へ" /></div>
				<div id="next" class="controllBtn right"><input type="button" value="" /></div>
			</div>';
		$data[]=$midiTxt;
	}



	// -------  講師・演奏者登録表示  -------
	elseif($_POST['idname']=="workers"){
		$sql = "select * from workers order by ID DESC";
		//$sql = "select * from workers where ID=2";
		$re = $db->run($sql);
		for($i = 0; $i < count($re); $i++){
			$optionVal .= '<option value="'.$re[$i]['ID'].'">'.$re[$i]['name'].'</option>';
		}

		$ary1 = array('継続', '退職予定', '退職');
		$ary2 = array('講師', '外部', 'スタッフ');
		$ary3 = array('アカデミック', 'ピンポイント', '集中講座', 'オンライン', 'グループ', 'イベント');
		$ary4 = array('日', '火', '水', '木', '金', '土');
		
		$sql = "select * from plv_option";
		$op = $db->run($sql);
		$ary5 = explode(',', $op[0]['major']);
		
		for($i = 0; $i < count($ary1); $i++){
			if($re[0]['work'] == $ary1[$i]){$check1 .= '<label><input type="radio" name="work" class="check" value="'.$ary1[$i].'" checked="checked" />'.$ary1[$i].'</label>　　';
			}else{$check1 .= '<label><input type="radio" name="work" class="check" value="'.$ary1[$i].'" />'.$ary1[$i].'</label>　　';}
		}
		for($i = 0; $i < count($ary2); $i++){
			if($re[0]['employment'] == $ary2[$i]){$check2 .= '<label><input type="radio" name="employment" class="check" value="'.$ary2[$i].'" checked="checked" />'.$ary2[$i].'</label>　　';
			}else{$check2 .= '<label><input type="radio" name="employment" class="check" value="'.$ary2[$i].'" />'.$ary2[$i].'</label>　　';}
		}
		for($i = 0; $i < count($ary3); $i++){
			if (strstr($re[0]['course'], $ary3[$i])){
					$check3 .= '<label><input type="checkbox" name="course" class="check course'.$i.'" value="'.$ary3[$i].'" checked="checked" />'.$ary3[$i].'</label>　　';
				}else{$check3 .= '<label><input type="checkbox" name="course" class="check course'.$i.'" value="'.$ary3[$i].'" />'.$ary3[$i].'</label>　　';}
		}
		for($i = 0; $i < count($ary4); $i++){
			if (strstr($re[0]['course'], $ary4[$i])){
					$check4 .= '<label><input type="checkbox" name="days" class="check days'.$i.'" value="'.$ary4[$i].'" checked="checked" />'.$ary4[$i].'</label>　　';
				}else{$check4 .= '<label><input type="checkbox" name="days" class="check days'.$i.'" value="'.$ary4[$i].'" />'.$ary4[$i].'曜</label>　　';}
		}
		
		for($i = 0; $i < count($ary5); $i++){
			if (strstr($re[0]['tag'], $ary5[$i])){
					$check5 .= '<label><input type="checkbox" name="tag" class="check days'.$i.'" value="'.$ary5[$i].'" checked="checked" />'.$ary5[$i].'</label>　　';
				}else{$check5 .= '<label><input type="checkbox" name="tag" class="check days'.$i.'" value="'.$ary5[$i].'" />'.$ary5[$i].'曜</label>　　';}
		}
		
		

		$sql = "select * from course where instructor='".$re[0]['ID']."'";
		$re1 = $db->run($sql);
		if($re1){
			
			$course = '
						<div class="courseType">【 アカデミック 】<span class="add">＋</span></div>
						<table class="courseTable academic">
							<tr>
								<th class="coruseTh1"></th><td><input type="text" class="course_name" name="about_name" value="'.$re1[0]['name'].'" /></td>
								<th>コース名</th><td><input type="text" class="course_name" name="course_name" value="'.$re1[0]['name'].'" /></td>
								<th>時間</th><td class="coruseTh2"><input type="text" class="course_ipt" name="course_time" value="'.$re1[0]['name'].'" /></td>
								<th>回数</th><td class="coruseTh2"><input type="text" class="course_ipt" name="course_num" value="'.$re1[0]['name'].'" /></td>
								<th>料金（税込）</th><td class="coruseTh2"><input type="text" class="course_ipt" name="course_price" value="'.$re1[0]['name'].'" /></td>
							</tr>
							<tr><th class="coruseTh1">説明</th><td colspan="9" class="coruseTd"><textarea class="course_detail" name="course_detail">'.$re1[0]['detail'].'</textarea></td></tr>
						</table>';
		}

		if($re[0]['employment'] == '講師'){
			
			$instructor = '<table class="workersTable">
						<tr><th>メタワード</th><td class="keywordsTd"><textarea name="keywords">'.$re[0]['keywords'].'</textarea></td></tr>
						<tr><th>メタデスクリプション</th><td class="descriptionTd"><textarea name="description">'.$re[0]['description'].'</textarea></td></tr>
						<tr><th>担当名</th><td><input type="text" name="responsible" value="'.$re[0]['responsible'].'" /></td></tr>
						<tr><th>担当科目</th><td class="majorTd"><textarea name="major">'.$re[0]['major'].'</textarea></td></tr>
						<tr><th>得意ジャンル</th><td class="specialty_genreTd"><textarea name="specialty_genre">'.$re[0]['specialty_genre'].'</textarea></td></tr>
						<tr><th>学歴</th><td class="educationalTd"><textarea name="educational">'.$re[0]['educational'].'</textarea></td></tr>
						<tr><th>キャッチフレーズ</th><td class="catchphraseTd"><textarea name="catchphrase">'.$re[0]['catchphrase'].'</textarea></td></tr>
						<tr><th>プロフィール画像</th><td><input type="text" name="image" value="'.$re[0]['image'].'" /></td></tr>
						<tr><th>プロフィール</th><td class="profileTd"><textarea name="profile">'.$re[0]['profile'].'</textarea></td></tr>
						<tr><th>一言</th><td class="commentTd"><textarea name="comment">'.$re[0]['comment'].'</textarea></td></tr>
						<tr><th>資格</th><td class="licenseTd"><textarea name="license">'.$re[0]['license'].'</textarea></td></tr>
						<tr><th>作品</th><td class="productTd"><textarea name="product">'.$re[0]['product'].'</textarea></td></tr>
					</table>

					<table class="workersTable">
						<tr><th></th><td id="majorCategory">　'.$check5.'</td></tr>
						<tr><th>コース</th><td id="course">　'.$check3.'</td></tr>
						<tr><th>曜日</th><td id="days">　'.$check4.'</td></tr>
					</table>
						'.$course;
			
		}

		$workersTxt = '<style type="text/css">#wrapper{width:100%;}</style>
				<form id="workersForm" method="post">
					<table class="workersTable">
						<tr><th colspan="2">ID</th><td><input type="text" id="workersId" name="ID" value="'.$re[0]['ID'].'" readonly /></td></tr>
						<tr>
							<th colspan="2">勤務'.count($corse).'</th>
							<td>
								　'.$check1.'
							</td>
						</tr>
						<tr>
							<th colspan="2">形態</th>
							<td>
								　'.$check2.'
							</td>
						</tr>
						<tr><th colspan="2">英語</th><td><input type="text" name="english" value="'.$re[0]['english'].'" /></td></tr>
						<tr><th colspan="2">フリガナ</th><td><input type="text" name="furigana" value="'.$re[0]['furigana'].'" /></td></tr>
						<tr><th colspan="2">氏名</th><td><input type="text" name="name" value="'.$re[0]['name'].'" /></td></tr>
						<tr><th rowspan="4">住所</th><th>郵便番号</th><td><input type="text" id="postal" class="postal" maxlength="7" name="postal" value="'.$re[0]['postal'].'" /></td></tr>
						<tr><th>町域まで</th><td><input type="text" id="prefecture" class="prefecture" name="prefecture" value="'.$re[0]['prefecture'].'" /></td></tr>
						<tr><th>　番地号</th><td><input type="text" id="city" class="city" name="city" value="'.$re[0]['city'].'" /></td></tr>
						<tr><th>　その他</th><td><input type="text" name="address" value="'.$re[0]['address'].'" /></td></tr>
						<tr><th colspan="2">電話番号</th><td><input type="text" name="tel" value="'.$re[0]['tel'].'" /></td></tr>
						<tr><th colspan="2">携帯番号</th><td><input type="text" name="mobile" value="'.$re[0]['mobile'].'" /></td></tr>
						<tr><th colspan="2">E-Mail</th><td><input type="text" name="mail1" value="'.$re[0]['mail1'].'" /></td></tr>
						<tr><th colspan="2">携帯E-Mail</th><td><input type="text" name="mail2" value="'.$re[0]['mail2'].'" /></td></tr>
						<tr><th rowspan="3">振込先</th><th>　銀行名</th><td><input type="text" name="bank" value="'.$re[0]['bank'].'" /></td></tr>
						<tr><th>　支店名</th><td><input type="text" name="branch" value="'.$re[0]['branch'].'" /></td></tr>
						<tr><th>口座番号</th><td><input type="text" name="number" value="'.$re[0]['number'].'" /></td></tr>
						<tr><th colspan="2">楽器</th><td><input type="text" name="instrument" value="'.$re[0]['instrument'].'" /></td></tr>
						<tr><th colspan="2">ジャンル</th><td><input type="text" name="genre" value="'.$re[0]['genre'].'" /></td></tr>
						<tr><th colspan="2">Webサイト</th><td><input type="text" name="website" value="'.$re[0]['website'].'" /></td></tr>
					</table>
					'.$instructor.'
					
					<div id="workers" class="controll clearfix">
						<input type="button" id="new" value="新規" class="btn" />
						<input type="button" id="save" value="保存" class="btn" />
						<input type="button" id="newSave" value="保存" class="btn" />
						
						<div id="select"><select id="listSelect" name="list">'.$optionVal.'</select></div>
						<div id="prev" class="controllBtn left"><input type="button" id="prevBtn" value="前へ" /></div>
						<div id="next" class="controllBtn right"><input type="button" value="" /></div>
					</div>
				</form>';
		$data[] = $workersTxt;
	}

	// -------  講師・演奏者一覧表示  -------
	elseif($_POST['idname']=="staffList"){
		$sql = "select * from workers where work='継続' and employment='講師' order by ID ASC";
		$re = $db->run($sql);
		for($i = 0; $i < count($re); $i++){
			$workersVal .= '<tr class="result_list workersList">
								<td>'.($i+1).'<input type="hidden" name="indexID" value="'.$re[$i]['ID'].'" /></td>
								<td><span style="color:#f00000;">'.$re[$i]['employment'].'</span></td>
								<td>'.$re[$i]['name'].'</td>
								<td>〒'.$re[$i]['postal'].'　'.$re[$i]['prefecture'].' '.$re[$i]['city'].'<br />'.$re[$i]['address'].'</td>
								<td>'.$re[$i]['mobile'].'</td>
								<td>'.$re[$i]['mail1'].'</td>
								<td width="150">'.$re[$i]['bank'].'</td>
								<td width="150">'.$re[$i]['branch'].'</td>
								<td width="150">'.$re[$i]['number'].'</td>
							</tr>';
		}

		$staffListTxt = '<style type="text/css">#wrapper{width:100%;}</style>
				<p id="workersSelect">
					<label><input type="radio" name="result" class="check" value="0" />全て</label>　　
					<label><input type="radio" name="result" class="check" value="1" checked="checked" />講師</label>　　　
					<label><input type="radio" name="result" class="check" value="2" />作編曲・演奏者</label>　　
					<label><input type="radio" name="result" class="check" value="3" />スタッフ</label>　　
					<label><input type="radio" name="result" class="check" value="4" />退職予定者</label>　　
					<label><input type="radio" name="result" class="check" value="5" />退職者</label>　　
					検索　:　<input type="text" id="str" />　　
					表示件数　<span id="total">'.count($re).'</span>
				</p>
				<table id="workersListTable" class="tablesorter">
					<thead>
						<tr><th width="30"></th><th width="70">形態</th><th width="140">氏名</th><th width="400">住所</th><th width="140">電話番号</th><th width="300">E-Mail</th><th colspan="3">振込先</th></tr>
					</thead>
					<tbody>'.$workersVal.'</tbody>
				</table>
				<div id="modalContens">
					<h2>　　　<img src="/images/material/close.png" id="closeImg" title="閉じる" /></h2>
					<table>
						<tr><th>ID</th><td colspan="3"></td></tr>
						<tr><th>形態</th><td colspan="3"></td></tr>
						<tr><th>フリガナ</th><td colspan="3"></td></tr>
						<tr><th>氏名</th><td colspan="3"></td></tr>
						<tr><th>住所</th><td colspan="3"></td></tr>
						<tr><th>電話番号</th><td colspan="3"></td></tr>
						<tr><th>携帯番号</th><td colspan="3"></td></tr>
						<tr><th>E-Mail</th><td colspan="3"></td></tr>
						<tr><th>携帯E-Mail</th><td colspan="3"></td></tr>
						<tr><th>振込先</th><td></td><td></td><td></td></tr>
						<tr><th>専攻楽器</th><td colspan="3"></td></tr>
						<tr><th>ジャンル</th><td colspan="3"></td></tr>
						<tr><th>Webサイト</th><td colspan="3"></td></tr>
					</table>
				</div>';
		$data[] = $staffListTxt;
	}
	
	
	$data['selectID'] = $_POST['selectid'];
	$data['completionName'] = $_POST['contentName'];
	// -------  JSON 出力  -------
	echo json_encode($data);
?>