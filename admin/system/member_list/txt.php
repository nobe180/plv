<?php
	$sql = "select * from user_master where 1 and (school='1') and (full='1') and (recess='0' or recess='1')";
	$re = $db->run($sql);
	$ary = array('registration', 'admission', 'withdrawal');

		for($i = 0; $i < count($re); $i++){
			
			for($t = 0; $t < count($ary); $t++){
				$date[$t] = $re[$i][$ary[$t].'_date'];
				if($date[$t] == '0000-00-00'){
					$date[$t] = '';
				}
			}	

			$listVal .= '<tr class="result_list">
								<td><input type="hidden" name="index_id" value="'.$re[$i]['ID'].'" />'.$re[$i]['ID'].'</td>
								<td>'.$re[$i]['name'].'</td>
								<td>'.$re[$i]['furigana'].'</td>
								<td>'.$re[$i]['tel1'].'</td>
								<td>'.$re[$i]['tel2'].'</td>
								<td>'.$re[$i]['mail1'].'</td>
								<td>'.$date[0].'</td>
								<td>'.$date[1].'</td>
								<td>'.$date[2].'</td>
							</tr>';
				
			//$t = array();
			//$t = explode ('/', $re[$i]['birthday']);		
			//$sql1 = "update school set birthday_Y='".$t[0]."', birthday_M='".$t[1]."', birthday_D='".$t[2]."' where ID='".$re[$i]['ID']."'";		
			//$sql1 = "insert into school(user_ID, admission) value('".$re[$i]['ID']."', '".$re[$i]['registration_date']."')";
			$sql1 = "update user_master set admission_studio='0000-00-00', admission_school='".$re[$i]['registration_date']."' where ID='".$re[$i]['ID']."'";	
			//$re1=$db->run($sql1);	
		}

		$content_txt = '<link rel="stylesheet" type="text/css" href="/admin/system/member_list/index.css" />
					<script type="text/javascript" src="/admin/system/member_list/index.js"></script>
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
							<th>ID</th><th>氏名</th><th>フリガナ</th><th>電話番号</th><th>携帯番号</th><th>E-Mail</th><th>登録日</th><th>入会日</th><th>退会日</th>
						</tr>
					
					</thead>
					<tbody>'.$listVal.'</tbody>
				</table>

				<div id="modal">
					<div class="txt_right">
						<img src="/program/images/material/save.png" id="saveImg" title="保存" width="30" height="30" class="non_print" />
						<img src="/program/images/material/close.png" id="closeImg" title="閉じる" class="non_print" />
					</div>
					<input type="hidden" name="user_ID" value="" />
					<table class="userModal">
						<tr><th>部門</th><td colspan="5"></td></tr>
						<tr><th>会員種別</th><td colspan="5"></td></tr>
						<tr><th>状態</th><td colspan="5"></td></tr>
						<tr><th>フリガナ</th><td colspan="5"></td></tr>
						<tr><th>氏名</th><td colspan="5"></td></tr>
						<tr><th>生年月日</th><td colspan="5"></td></tr>
						<tr><th>性別</th><td colspan="5"></td></tr>
						<tr><th>住所</th><td colspan="5"></td></tr>
						<tr><th>電話番号</th><td colspan="5"></td></tr>
						<tr><th>携帯番号</th><td colspan="5"></td></tr>
						<tr><th>E-Mail</th><td colspan="5"></td></tr>
						<tr><th>携帯E-Mail</th><td colspan="5"></td></tr>
						<tr><th>備考</th><td colspan="5"></td></tr>
						<tr><th>Skype ID</th><td colspan="5"></td></tr>
						<tr><th>登録日</th><td></td><th>入会日</th><td></td><th>退会日</th><td></td>	</tr>
						<tr><th>退会理由</th><td colspan="5"></td></tr>
					</table>
					<p class="non_print">
						<span id="modal_save"><input type="button" id="conf" value="設定" class="btn" /></span>　
						<span id="modal_cancel"><input type="button" id="cancel" value="キャンセル" class="btn" /></span>
					</p>
				</div>';
?>