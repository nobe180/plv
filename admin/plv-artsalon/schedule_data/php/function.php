<?php
	function getWeek($ymd) {
		//週始まりを月曜日にするなら、$w + 1　にする
		$w = date("w",strtotime($ymd));
		$beginning_week_date = date('Y-n-j', strtotime("-{$w} day", strtotime($ymd)));
		return $beginning_week_date;
	}

	function diffTime($start, $end) {
		// 日時
		$from = date('Y-m-j').'-'.$start;
		$to = date('Y-m-j').'-'.$end;
 
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
?>