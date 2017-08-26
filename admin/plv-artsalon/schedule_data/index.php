<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	require('php/config.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW" />
		<title></title>
		<link rel="stylesheet" type="text/css" href="stylesheets/index.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/modal.css" />
		<link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="javascript/index.js"></script>
		<script src="https://plv-music.com/program/javascript/autosize.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
		<script type="text/javascript" src="https://jpostal-1006.appspot.com/jquery.jpostal.js"></script>
	</head>

	<body>
		<div id="test"></div>
		<input type="hidden" id="weekData" value="<?= $_GET['id']; ?>" />
		<div id="control">　
			<a href="./?id=<?= date('Y/n/j', strtotime('-7 day', $getWeek)); ?>"><input type="button" class="Btn" id="prevWeek" value="← Back" /></a>　
			<input type="text" class="datepicker" id="fixedTerm" size="18" value="<?= $firstWeek; ?> 〜 <?= $lastWeek; ?>" />　
			<a href="./?id=<?= date('Y/n/j', strtotime('+7 day', $getWeek)); ?>"><input type="button" class="Btn" value="Next →" /></a>　　	
			<a href="./"><input type="button" class="Btn today" value="TODAY" /></a>
		</div>

		<div id="contents" class="clearfix">
			<table class="timeDef"><?= $timelineDef; ?></table>
			<?= $table; ?>
			<!--<table class="timeDef"><?= $timelineDef; ?></table>	-->
		</div>
		
		<div id="modal">
			<div class="txt_right">
				<img src="images/save.png" id="saveImg" title="保存" width="30" height="30" class="non_print" />
				<img src="images/close.png" id="closeImg" title="閉じる" class="non_print" />
			</div>
			<table class="schduleModal">
				<tr><th>カテゴリー</th><td colspan="3"></td></tr>
				<tr><th>団体名</th><td colspan="3"></td></tr>
				<tr><th>担当者</th><td colspan="3"></td></tr>
				<tr><th>性別</th><td colspan="3"></td></tr>
				<tr><th>住所</th><td colspan="3"></td></tr>
				<tr><th>電話番号</th><td colspan="3"></td></tr>
				<tr><th>メールアドレス</th><td colspan="3"></td></tr>
				<tr><th>日程</th><td colspan="3"></td></tr>
				<tr><th>予約時間（開始）</th><td></td><th>予約時間（終了）</th><td></td></tr>
				<tr><th>料金</th><td colspan="3"></td></tr>
				<tr><th>詳細時間</th><td colspan="3"></td></tr>
				<tr><th>詳細料金</th><td colspan="3"></td></tr>
				<tr><th>タイトル</th><td colspan="3"></td></tr>
				<tr><th>画像</th><td colspan="3"></td></tr>
				<tr><th>備考</th><td colspan="3"></td></tr>
				<tr><th>登録日</th><td colspan="3"</td></tr>
			</table>
			<p class="control">
				<span id="modal_save"><input type="button" id="conf" value="設定" class="btn" /></span>　
				<span id="modal_cancel"><input type="button" id="cancel" value="キャンセル" class="btn" /></span>
			</p>
		</div>
	</body>
</html>