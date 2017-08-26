<?php require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php'); ?>
<?php require_once('header.php'); ?>
<!-- ************* コンテンツ ************* -->
			<h1>ようこそ管理者様</h1>
			<article id="wrapper">

<?php
	$sql = "select * from counseling";
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






				左のメニューから項目をお選びください。
			</article>

<!-- ************* ここまで ************* -->
<?php require_once('footer.php'); ?>