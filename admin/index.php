<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	admin_check();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW" />
		<link rel="stylesheet" type="text/css" href="index.css" />
		<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
		<link rel="stylesheet" href="<?= $dir; ?>program/stylesheets/tablesorter.css">
		<style type="text/css">
    		/* 土日を赤にする */
			.ui-datepicker-week-end, .ui-datepicker-week-end a.ui-state-default{color:red;}
		</style>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
		<script type="text/javascript" src="http://jpostal-1006.appspot.com/jquery.jpostal.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
		<script src="<?= $dir; ?>program/javascript/prefixfree.min.js"></script>
		<script src="<?= $dir; ?>program/javascript/jquery.tablesorter.min.js"></script>
		<script src="<?= $dir; ?>program/javascript/autosize.min.js"></script>
		<script src="index.js"></script>
		<title>管理者専用ページ</title>
	</head>

	<body>
		<header>
			<h1>PLV music network</h1>
			<h2>管理者MENU</h2>
			<a href="/admin"><span class="icon"><img src="/program/images/material/home_2.png" title="管理者メインページ" /></a></span>
			<a href="logout"><span class="icon"><img src="/program/images/material/logout.png" title="ログアウト" /></span></a>
			<ul class="clear">
				<li><a href="MySiteEdit">Webサイト編集</a></li>
			</ul>
			<ul class="clear">
				<li id="workers">スタッフ登録と変更</li>
				<li id="staffList">スタッフ一覧</li>
				<li id="memberList">会員情報</li>
				<li id="studioSchedule">スタジオスケジュール</li>
				<li id="studioPayment">スタジオ支払状況</li>
				<li id="onlineSchedule">オンラインスケジュール</li>
				<li id="onlinePayment">オンライン支払状況</li>
			</ul>
			<ul class="clear">
				<li id="schoolWork">PLV音楽院業務</li>
				<li id="repairWork">楽器リペア業務</li>
				<li id="agencyWork">演奏派遣業務</li>
				<li id="prduceWork">楽曲制作業務</li>
			</ul>
			<ul class="clear">
				<li id="midiPass">MIDI検定4級試験パスワード生成</li>
				<li id="midiLicense">MIDI検定4級試験受講者リスト</li>
			</ul>
		</header>
		<div id="container">
			<h1>ようこそ管理者様</h1>
			<article id="wrapper">
<?php $sql = "select * from counseling";
		$re = $db->run($sql);
		
		$counseling = 0;
		$trial = 0;
		for($i = 0; $i < count($re); $i++){

			$day = day_diff($re[$i]['counseling_admission'], date('Y-m-d'));
			if($day < 3){
				if($re[$i]['result'] == 'カウンセリング') $counseling++;
				if($re[$i]['result'] == '体験レッスン') $trial++;
			}
		}

		if($counseling != 0) $txt1 = '<span style="font-weight:bold">カウンセリング</span> <span style="font-size:1.5em;color:#f00;">'.$counseling.'</span> 件';
		if($trial != 0) $txt2 = '<span style="font-weight:bold">体験レッスン</span> <span style="font-size:1.5em;color:#f00;">'.$trial.'</span> 件';
		if($counseling != 0 && $trial != 0) $br = '、';
		if($counseling != 0 || $trial != 0){
			$txt3 = '<p class="blinking">';
			$txt4 = 'の問い合わせがあります。</p>';
		}
		$ifno = $txt3.$txt1.$br.$txt2.$txt4;
		
?>

				<?= $ifno; ?>

				左のメニューから項目をお選びください。
			</article>
		</div>

	</body>
</html>






<?php
	function day_diff($date1, $date2) {
		// 日付をUNIXタイムスタンプに変換
		$timestamp1 = strtotime($date1);
		$timestamp2 = strtotime($date2);
		// 何秒離れているかを計算
		$seconddiff = abs($timestamp2 - $timestamp1);
		// 日数に変換
		$daydiff = $seconddiff / (60 * 60 * 24);
		return $daydiff;
	}
?>