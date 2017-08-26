<?php
	$sql = "select * from user_master where mail_delivery=1";
	$re = $db->run($sql);
	$ary = array('registration', 'admission', 'withdrawal');

		for($i = 0; $i < count($re); $i++){
		//for($i = 0; $i < 3; $i++){	
			for($t = 0; $t < count($ary); $t++){
				$date[$t] = $re[$i][$ary[$t].'_date'];
				if($date[$t] == '0000-00-00'){
					$date[$t] = '';
				}
			}
			
			$cheked = '<td><label class="check_design"><input type="checkbox" name="" value="'.$re[$i]['ID'].'" /><span class="lever">OFF</span></label></td>';
			if($re[$i]['mail_delivery'] == '1'){
				$cheked = '<td><label class="check_design"><input type="checkbox" name="" value="'.$re[$i]['ID'].'" checked /><span class="lever">ON</span></label></td>';
			}
			$listVal .= '<tr class="result_list">
								<td><input type="hidden" name="index_id" value="'.$re[$i]['ID'].'" />'.$re[$i]['ID'].'</td>
								<td>'.$re[$i]['name'].'</td>
								<td>'.$re[$i]['furigana'].'</td>
								<td>'.$re[$i]['mail1'].'</td>
								<td>'.$re[$i]['mail2'].'</td>
								'.$cheked.'
							</tr>';
		}

		$content_txt = '<link rel="stylesheet" type="text/css" href="/admin/system/mail_list/index.css" />
					<script type="text/javascript" src="/admin/system/mail_list/index.js"></script>
					<div id="test"></div>
				<div id="refine_select">
					<img src="/program/images/material/new_page.png" title="新規" id="new_list" />　　
					<label><input type="checkbox" name="refine_full" value="0" checked="checked" />正会員</label>　　
					<label><input type="checkbox" name="refine_associate" value="0" />準会員</label>　　
					<label><input type="checkbox" name="refine_online" value="0" />オンライン会員</label>　　
					<label><input type="checkbox" name="refine_studio_" value="0" />スタジオ会員</label>　　
					<label><input type="checkbox" name="refine_other_" value="0" />その他</label><br />　　　　
					<label><input type="checkbox" name="refine_recess" value="0" checked="checked" />休会</label>　　 
					<label><input type="checkbox" name="refine_withdrawal" value="0" />退会</label><br />　　　　
					<label><input type="checkbox" name="refine_repair" value="0" />楽器リペア</label>　　
					<label><input type="checkbox" name="refine_agency" value="0" />演奏派遣</label>　　
					<label><input type="checkbox" name="refine_produce" value="0" />楽曲制作</label>　　
					<label><input type="checkbox" name="refine_other" value="0" />その他</label><br />　
					<select name="item">
						<option value="name, furigana">氏名</option>
						<option value="ID">ID</option>
						<option value="tel1, tel2">電話番号</option>
						<option value="mail1, mail2">メール</option>
					</select>　　検索　:　<input type="text" name="string" />　<input type="button" id="search" value="検索" /><br />
					表示件数　<span id="total">'.count($re).'</span>
				</div>
				<table id="list_table" class="tablesorter">
					<thead>
						<tr>
							<th>ID</th><th>氏名</th><th>フリガナ</th><th>メール1</th><th>メール2</th><th>チェック</th>
						</tr>
					
					</thead>
					<tbody>'.$listVal.'</tbody>
				</table>';
?>