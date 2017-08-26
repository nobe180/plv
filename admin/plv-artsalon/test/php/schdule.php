<?php
	// 現在の年月を取得
	$year = date('Y');
	$month = date('n');;

	if($_GET['year']){
		$year = $_GET['year'];
		$month = $_GET['month'];
	}

	$start_date = $year.'-'.$month.'-1';
	$end_date = $year.'-'.$month.'-31';
	$sql = "select * from ppc_schedule where date_ between '".$start_date."' and '".$end_date."' and del=0 order by start_time ASC";
	$re = $db->run($sql);
	//echo count($re);

	$date_array = array();
	for($i = 0; $i < count($re); $i++){
		$Arry = explode('-', $re[$i]['date_']);
		$id = ltrim($Arry[2], '0');

		if($re[$i]['department'] == 1 || $re[$i]['department'] == 5){//ライブまたはセッション
			if($re[$i]['department'] == 1){
				$live_session[$id] = 'LIVE';
				$session[$id] = '';
			}else{
				$live_session[$id] = 'SESSION';
				$session[$id] = 'session ';
			}
			
			$live[$id] .= $re[$i]['start_time'].'～'.$re[$i]['end_time'].',';
			$live_title[$id] = $re[$i]['title'];
			$live_image[$id] = $re[$i]['image'];
			$live_price[$id] = $re[$i]['price'];
			$live_id[$id] = $re[$i]['ID'];
		}else if($re[$i]['department'] == 2){//レンタル
			$rental[$id] .= $re[$i]['start_time'].'～'.$re[$i]['end_time'].',';
		}else if($re[$i]['department'] == 3){//バータイム
			$bar[$id] .= $re[$i]['start_time'].'～'.$re[$i]['end_time'].',';
		}
		array_push($date_array, $id);
	}

	$ary = array_unique($date_array);//重複削除
	$ary = array_values($ary);//配列並べ替え

	for($i = 0; $i < count($ary); $i++){
		$rental_txt	= '';
		$bar_txt	= '';
		$live_txt	= '';
		$image = '';
			if($rental[$ary[$i]]){
				$rental_txt = '<div class="space sp_box"><dl><dt>レンタル</dt><dd>'.str_replace(',', '<br />', $rental[$ary[$i]]).'</dd></dl></div>';
			}
			if($bar[$ary[$i]]){
				$bar_txt = '<div class="bar_time sp_box"><dl><dt>Bar Time</dt><dd>'.str_replace(',', '<br />', $bar[$ary[$i]]).'</dd></dl></div>';
			}
			if($live[$ary[$i]]){
				if($live_image[$ary[$i]]){
					$image = '<div class="live_image"><img src="http://plv-artsalon.com/schedule_data/upload_file/'.$live_image[$ary[$i]].'"></div>';
				}
				$live_txt = '<span class="on"><span>詳　細</span><span class="target_id">'.$live_id[$ary[$i]].'</span></span><div class="live '.$session[$ary[$i]].'sp_box"><dl><dt>'.$live_session[$ary[$i]].'</dt><dd>'.str_replace(',', '<br />', $live[$ary[$i]]).'</dd></dl></div><div class="live_title">【'.$live_title[$ary[$i]].'】</div>'.$image;
			}
			$date_txt[$ary[$i]] = $rental_txt.$bar_txt.$live_txt;
	}


	$day_name = array('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT');
	foreach($day_name as $value){
		$day_ .= '<div class="'.mb_strtolower($value).'">'.$value.'</div>';
	}

	// 月末日を取得
	$last_day = date('j', mktime(0, 0, 0, $month + 1, 0, $year));
	$calendar = array();
	$j = 0;

	// 月末日までループ
	for($i = 1; $i < ($last_day+1); $i++){
		$week = date('w', mktime( 0, 0, 0, $month, $i, $year));// 曜日を取得
		// 1日の場合
		if($i == 1) {
			// 1日目の曜日までをループ
			for($s = 1; $s <= $week; $s++) {
				// 前半に空文字をセット
				$calendar[$j]['day'] = '';
				$j++;
			}
		}

		// 配列に日付をセット
		$calendar[$j]['day'] = '<span class="date">'.$i.'</span><span class="day_name">  '.$day_name[$week].'</span>';
		$j++;
		// 月末日の場合
		if ($i == $last_day){
			// 月末日から残りをループ
			for ($e = 1; $e <= (6-$week); $e++) {
				// 後半に空文字をセット
				$calendar[$j]['day'] = '';
				$j++;
			}
		}
	}

	$cnt = 0;
	foreach($calendar as $key => $value){
	//<span class="day_name">  WED</span>
		$cnt++;
		$today = '';
		$num = preg_replace('/[^0-9]/', '', $value['day']);
		if($cnt == 1){
			$date_ .= '			<div class="week_box">'."\n";
		}
		$class_ = mb_strtolower($day_name[($cnt-1)]);//小文字に変換

		$today_txt = '<span class="date">'.date(j).'</span><span class="day_name">  '.$day_name[date('w')].'</span>';
		
		if($year == date('Y') && $month == date('n') && $value['day'] == $today_txt){
		
			$today = ' today';
		}
		$disp = '';
		if($value['day'] == ''){
			$disp = ' disp';
		}

		$date_ .= '				<div class="'.$class_.$today.$disp.'">'.$value['day'].$date_txt[$num].'</div>'."\n";
		if($cnt == 7){
			$date_ .= '			</div>'."\n";
			$cnt = 0;
		}
	}

	$this_month = $month;
	$t = $this_month+1;
	$year_ = $year;
	for($i = 0; $i < 5; $i++){
		if($t == 13){
			$t = 1;
		}
		$year_class = '';
		if($t == 1){
			$year_ = $year+1;
			$year_class = '<span class="month_year">'.$year_.'</span>';
		}
		$month_after .= '<div>'.$year_class.'<a href="?year='.$year_.'&month='.$t.'#schedule" class="no_exe">'.$t.'</a></div>';
		if($t == 12){
			$t = 0;
		}
		$t++;
	}
	$year_ = $year;
	$t = $this_month-1;
	for($i = 0; $i < 5; $i++){
		if($t == 0){
			$t = 12;
			$year_ = $year-1;
		}
		$year_class = '';
		if($t == 1){
			$year_class = '<span class="month_year">'.$year_.'</span>';
		}
		$month_before .= '<div>'.$year_class.'<a href="?year='.$year_.'&month='.$t.'#schedule" class="no_exe">'.$t.'</a></div>';
		$t--;
	}

	$month_sel = '<div id="month_before">'.$month_before.'</div>
								<div class="this_month">'.$this_month.'</div>
								<div id="month_after">'.$month_after.'</div>';

	$year_ = $year;
	$year_next = $year;
	$prev_month = $this_month-1;
	$next_month = $this_month+1;
	if($this_month == 1){
		$prev_month = 12;
		$year_ = $year-1;
	}else if($this_month == 12){
		$next_month = 1;
		$year_next = $year+1;
	}

	$prev_btn = '?year='.$year_.'&month='.$prev_month;
	$next_btn = '?year='.$year_next.'&month='.$next_month;
?>

		<section id="schedule" class="main_style">
			<div class="title"><img src="images/schedule.png" alt="PPC Schedule"/></div>

			<div id="calender">
			<h1><?= $year; ?><span>年</span> <?= $month; ?> <span>月</span></h1>
				<div id="month_select">
					<div id="schedule_prev"><a href="<?= $prev_btn; ?>#schedule" class="month_btn no_exe"></a></div>
					<?= $month_sel; ?>
					<div id="schedule_this"><a href="./" class="month_btn">This Month</a></div>
					<div id="schedule_next"><a href="<?= $next_btn; ?>#schedule" class="month_btn no_exe"></a></div>
				</div>
				<div id="day_box"><?= $day_; ?></div>
				<?= $date_; ?>
			</div>

			<div id="modal">
				<div class="txt_right">
					<img src="http://plv-artsalon.com/schedule_data/images/close.png" id="closeImg" title="閉じる" class="non_print" />
				</div>
				<table class="schduleModal">
					<tr><th>Title</th><td colspan="3"></td><th rowspan="4" class="live_image"><img src="http://plv-artsalon.com/schedule_data/images/no_image.png" /></th></tr>
					<tr><th>Date</th><td colspan="3"></td></tr>
					<tr><th>Music Charge</th><td colspan="3"></td></tr>
				</table>
			</div>
		</section>