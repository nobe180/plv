<?php
	$sql = "select * from counseling_sheet where user_ID <> '' and admission BETWEEN '".date('Y-m-d', strtotime('-1 month'))."' and '".date('Y-m-d')."' order by admission asc";
	$re = $db->run($sql);
		for($i = 0; $i < count($re); $i++){
			if($re[$i]['result_etc'] == '体験レッスン') $color = 'ff3300';
			if($re[$i]['result_etc'] == 'カウンセリング') $color = '0066cc';
			if($re[$i]['result_etc'] == '来訪') $color = 'ff9900';
			$sql = "select * from user_master where ID='".$re[$i]['user_ID']."'";
			$user = $db->run($sql);
			$listVal .= '<tr class="result_list">
								<td><span style="color:#'.$color.';">'.$re[$i]['result_etc'].'</span><input type="hidden" name="index_id" value="'.$re[$i]['ID'].'" /></td>
								<td>'.$re[$i]['admission'].'</td>
								<td>'.$user[0]['name'].'</td>
								<td>'.mb_convert_kana($user[0]['furigana'], 'k', 'UTF-8').'</td>
								<td>'.$user[0]['tel2'].'</td>
								<td>'.$user[0]['mail1'].'</td>
								<td><div class="overflow">'.$re[$i]['major'].'</div></td>
							</tr>';
		}
		
		$content_txt = '<link rel="stylesheet" type="text/css" href="/admin/system/school_work/index.css" />
					<script type="text/javascript" src="/admin/system/school_work/index.js"></script>
				<div id="refine_select">
					<img src="/program/images/material/new_page.png" title="新規" id="new_list" />
					<label><input type="radio" name="refine" class="check" value="0" />全て</label>　　
					<label><input type="radio" name="refine" class="check" value="1" />体験レッスン</label>　　　
					<label><input type="radio" name="refine" class="check" value="2" />カウンセリング</label>　　　
					<label><input type="radio" name="refine" class="check" value="3" />来訪</label>　<br />
　　			<label><input type="radio" name="pc_sp" class="check" value="all" />全て</label>　　　
					<label><input type="radio" name="pc_sp" class="check" value="PC" />PC</label>　　　
					<label><input type="radio" name="pc_sp" class="check" value="SP" />SP</label>　　　 
					<label><input type="radio" name="pc_sp" class="check" value="" />不明</label>　<br />
					　　期間　:　<input type="text" name="period1" class="datepicker" size="10" />　～　<input type="text" name="period2" class="datepicker" size="10" /><br />
					　　<select name="item">
								<option value="ID">ID</option>
								<option value="name">氏名</option>
								<option value="furigana">フリガナ</option>
								<option value="tel1, tel2">電話番号</option>
								<option value="mail1, mail2">メール</option>
								<option value="major">専攻</option>
							</select>　　検索　:　<input type="text" name="string" />　<input type="button" id="search" value="検索" /><br />
					表示件数　<span id="total">'.count($re).'</span>
				</div>
				<table id="list_table" class="tablesorter">
					<thead>
						<tr><th width="140"></th><th width="100">申込日</th><th width="140">氏名</th><th width="140">フリガナ</th><th width="140">電話番号</th><th width="300">E-Mail</th><th>目的</th></tr>
					</thead>
					<tbody>'.$listVal.'</tbody>
				</table>

				<div id="modal">
					<h2>
						カウンセリングシート<img src="/program/images/material/print.png" id="printImg" title="印刷" onclick="window.print();" class="non_print" />
						<img src="/program/images/material/save.png" id="saveImg" title="保存" width="30" height="30" class="non_print" />
						<img src="/program/images/material/close.png" id="closeImg" title="閉じる" class="non_print" />
					</h2>
					<table class="counselingModal">
						<tr>
							<th>
								<input type="hidden" id="userID" name="userID" value="" />
								<input type="hidden" id="counselingID" name="counselingID" value="" />
							</th>
							<td></td>
						</tr>
						<tr><th>申込日</th><td></td></tr>
						<tr><th>フリガナ</th><td></td></tr>
						<tr><th>氏名</th><td></td></tr>
						<tr><th>性別</th><td></td></tr>
						<tr><th>年齢</th><td></td></tr>
						<tr><th>年代</th><td></td></tr>
						<tr class="non_print"><th>電話番号（固定）</th><td></td></tr>
						<tr class="non_print"><th>電話番号（携帯）</th><td></td></tr>
						<tr class="non_print"><th>E-Mail（PC）</th><td></td></tr>
						<tr class="non_print"><th>E-Mail（携帯）</th><td></td></tr>
						<tr><th>PLVを知った場所</th><td></td></tr>
						<tr><th>ネット情報</th><td></td></tr>
						<tr><th>HP検索ワード</th><td></td></tr>
						<tr><th>紹介者</th><td></td></tr>
						<tr><th>目的</th><td></td></tr>
						<tr><th>これまでの音楽経験</th><td></td></tr>
						<tr><th>希望の音楽スタイル</th><td></td></tr>
						<tr><th>好きなアーティスト</th><td></td></tr>
						<tr><th>取り組み方</th><td></td></tr>
						<tr><th>その他、音楽に対すること、<br />何でもご記入ください。</th><td></td></tr>
						<tr class="trialTd"><th>希望の専攻</th><td></td></tr>
						<tr class="trialTd"><th>希望の講師</th><td></td></tr>
						<tr class="counselingTd"><th>Skype ID</th><td></td></tr>
						<tr><th>希望のレッスン日時</th><td></td></tr>
						<tr><th>備考</th><td></td></tr>
						<tr><th>面接者</th><td></td></tr>
					</table>
					<p class="non_print">
						<span id="modal_save"><input type="button" id="conf" value="設定" class="btn" /></span>　
						<span id="modal_cancel"><input type="button" id="cancel" value="キャンセル" class="btn" /></span>
					</p>
				</div>';
?>