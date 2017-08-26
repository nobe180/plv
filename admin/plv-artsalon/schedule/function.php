<?php
	require_once($_SERVER[ 'DOCUMENT_ROOT' ] . '/program/php/option.php');
	if($_POST['id']){
		$sql = "select * from ppc_schedule where ID='".$_POST['id']."'";
		$data['data'] = $db->run($sql);
		$data['memo'] = nl2br($data['data'][0]['memo']);


$data['day'] = Day($data['data'][0]['date_']);
		/*$date = $data['data'][0]['date_'];
		$datetime = new DateTime($date);
		$week = array('日', '月', '火', '水', '木', '金', '土');
		$w = (int)$datetime->format('w');
		$data['day'] = $week[$w];*/




		// -------  JSON 出力  -------
		echo json_encode($data);
	}


	function getWeek($ymd) {
		//週始まりを月曜日にするなら、$w + 1　にする
		$w = date("w",strtotime($ymd));
		$beginning_week_date = date('Y-n-j', strtotime("-{$w} day", strtotime($ymd)));
		return $beginning_week_date;
	}

	function diffTime($start, $end) {
		// 日時
		$from = date('Y-m-j').$start;
		$to = date('Y-m-j').$end;

		// 日時からタイムスタンプを作成
		$fromSec = strtotime($from);
		$toSec   = strtotime($to);
		$differences = $toSec - $fromSec;// 秒数の差分を求める
		$result = gmdate('H:i', $differences);// フォーマットする
		return ToMin($result);
	}

	function ToMin($time){
		$tArry = explode(":",$time);
		$hour = $tArry[0] * 60;//時間→分
		$secnd = round($tArry[2]/60,2);//秒→分　少数第2を丸めてる
		$mins = $hour+$tArry[1]+$secnd;//分だけを足す
		return $mins;
	}

	function Day($a){
		$date = $a;
		$datetime = new DateTime($date);
		$week = array('日', '月', '火', '水', '木', '金', '土');
		$w = (int)$datetime->format('w');
		return $week[$w];
	}
?>
