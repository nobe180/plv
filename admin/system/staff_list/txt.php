<?php
	$sql = "select * from staff where instructor='1' and retirement='0'";
	$re = $db->run($sql);
		for($i = 0; $i < count($re); $i++){
			$listVal .= '<tr class="result_list">
								<td><input type="hidden" name="index_id" value="'.$re[$i]['ID'].'" />'.$re[$i]['name'].'</td>
								<td>〒'.$re[$i]['postal'].'　'.$re[$i]['prefecture'].' '.$re[$i]['city'].'<br />'.$re[$i]['address'].'</td>
								<td>'.$re[$i]['tel2'].'</td>
								<td>'.$re[$i]['mail1'].'</td>
								<td width="150">'.$re[$i]['bank'].'</td>
								<td width="150">'.$re[$i]['branch'].'</td>
								<td width="150">'.$re[$i]['number'].'</td>
							</tr>';
		}
		
		$content_txt = '<link rel="stylesheet" type="text/css" href="/admin/system/staff_list/index.css" />
					<script type="text/javascript" src="/admin/system/staff_list/index.js"></script>
					<div id="test"></div>
				<div id="refine_select">
					<img src="/program/images/material/new_page.png" title="新規" id="new_list" />　　
					<label><input type="radio" name="refine" value="all" />全て</label>　　
					<label><input type="radio" name="refine" value="instructor" checked="checked" />講師</label>　　
					<label><input type="radio" name="refine" value="player" />作編曲・演奏者</label>　　
					<label><input type="radio" name="refine" value="repair" />リペア</label>　　
					<label><input type="radio" name="refine" value="staff" />スタッフ</label>　　
					<label><input type="radio" name="refine" value="retirement" />退職者</label><br />
					<select name="item">
						<option value="name">氏名</option>
						<option value="furigana">フリガナ</option>
						<option value="tel1, tel2">電話番号</option>
						<option value="mail1, mail2">メール</option>
						<option value="bank">振込先銀行名</option>
						<option value="instrument">専攻</option>
						<option value="genre">ジャンル</option>
					</select>　　検索　:　<input type="text" name="string" />　<input type="button" id="search" value="検索" /><br />
					表示件数　<span id="total">'.count($re).'</span>
				</div>
				<table id="list_table" class="tablesorter">
					<thead>
						<tr><th width="140">氏名</th><th width="500">住所</th><th width="140">電話番号</th><th width="300">E-Mail</th><th colspan="3">振込先</th></tr>
					</thead>
					<tbody>'.$listVal.'</tbody>
				</table>

				<div id="modal">
					<div class="txt_right">
						<img src="/program/images/material/save.png" id="saveImg" title="保存" width="30" height="30" class="non_print" />
						<img src="/program/images/material/close.png" id="closeImg" title="閉じる" class="non_print" />
					</div>
					<input type="hidden" name="staff_ID" value="" />
					<table class="instructorModal">
						<tr><th>形態</th><td colspan="3"></td></tr>
						<tr><th>英語</th><td colspan="3"></td></tr>
						<tr><th>フリガナ</th><td colspan="3"></td></tr>
						<tr><th>氏名</th><td colspan="3"></td></tr>
						<tr><th>生年月日</th><td colspan="3"></td></tr>
						<tr><th>性別</th><td colspan="3"></td></tr>
						<tr><th>住所</th><td colspan="3"></td></tr>
						<tr><th>電話番号</th><td colspan="3"></td></tr>
						<tr><th>携帯番号</th><td colspan="3"></td></tr>
						<tr><th>E-Mail（メイン1）</th><td colspan="3"></td></tr>
						<tr><th>E-Mail（メイン2）</th><td colspan="3"></td></tr>
						<tr><th>振込先</th><td></td><td></td><td></td></tr>
						<tr><th>専攻楽器</th><td colspan="3"></td></tr>
						<tr><th>ジャンル</th><td colspan="3"></td></tr>
						<tr><th>Webサイト</th><td colspan="3"></td></tr>
						<tr><th>備考</th><td colspan="3"></td></tr>
					</table>
					<p class="non_print">
						<span id="modal_save"><input type="button" id="conf" value="設定" class="btn" /></span>　
						<span id="modal_cancel"><input type="button" id="cancel" value="キャンセル" class="btn" /></span>
					</p>
				</div>';
?>