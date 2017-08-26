<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	require('php/function.php');

	if(!$_SESSION['plv']){
		url('http://plv-artsalon.com');
	}

	if(!$_GET['id']){
		$_GET['id'] = getWeek(date('Y-n-j'));
	}else{
		$_GET['id'] = getWeek($_GET['id']);
	}
	$days = date('Y-n-j', strtotime($_GET['id'].' +7 day'));
	$sql = "select * from ppc_schedule where date_ between '".$_GET['id']."' and '".$days."' and del=0";
	$re = $db->run($sql);

	$funkizami = 12; //５分刻み
	$display_num = 7; //表示数
	for($i = 0; $i < 1; $i++){  //部屋の数
		$room .= '<th>'.$roomAry[$i].'</th>';
	}

	$roomAry = array('PPC');
	$youbiAry = array('日', '月', '火', '水', '木', '金', '土');

	$getWeek = strtotime($_GET['id']);
	$firstWeek = date('Y/n/j', strtotime('0 day', $getWeek));
	$lastWeek = date('Y/n/j', strtotime('+6 day', $getWeek));

//echo $sql.'<br />'.$firstWeek.'<br />'.$lastWeek.'<br />'.$_GET['id'].'<br />'.$getWeek;
	for($i = 0; $i < $display_num; $i++){
		$ary = array();
		$getWeekAry[$i] = date('n/j', strtotime('+'.$i.' day', $getWeek));
		$target = date('m-d', strtotime('+'.$i.' day', $getWeek));
		$q = 0;
		$p = 10;
		for($t = 0; $t < count($re); $t++){
			if(strpos($re[$t]['date_'], $target) !== false){
				
				$startArry = explode(':', $re[$t]['start_time']);
				$endArry = explode(':', $re[$t]['end_time']);
				$total = diffTime($re[$t]['start_time'], $re[$t]['end_time']);
				$ary[$startArry[0]] = array('start_hour' => $startArry[0], 
											'start_minute' => $startArry[1], 
											'end_hour' => $endArry[0], 
											'end_minute' => $endArry[1], 
											'total' => $total,
											'id' => $re[$t]['ID'],
											'department' => $re[$t]['department'],
										    'company' => $re[$t]['company'],
										    'name' => $re[$t]['name'],
										    'tel' => $re[$t]['tel'],
										    'price' => $re[$t]['price']);	
			}
		}
if($i == 6){
	for($x = 10; $x < 24; $x++){
		//echo $x.'時= 開始: '.$ary[$x]['start_hour'].':'.$ary[$x]['start_minute'].'　　終了: '.$ary[$x]['end_hour'].':'.$ary[$x]['end_minute'].'　　分計算: '.$ary[$x]['total'].'　　ID: '.$ary[$x]['id'].'　　カテゴリー: '.$ary[$x]['department'].'<br />';
	}
}		
		
		for($v = 0; $v < (14 * $funkizami); $v++){
			$flalg = 0;
			$style_txt = '';
			//echo $v.'　　Q='.$q.'　　P='.$p.'<br />';
			if($p == $ary[$p]['start_hour']){
				if(sprintf('%02d', $q) == $ary[$p]['start_minute']){
					//echo sprintf('%02d', $q).' = '.$ary[$p]['start_minute'].'<br />';
					if($ary[$p]['department'] == 1){
						$bg = '#da706f';//ライブ
					}else if($ary[$p]['department'] == 2){
						$bg = '#596893';//レンタル
					}else if($ary[$p]['department'] == 3){
						$bg = '#bebe75';//バータイム
					}else if($ary[$p]['department'] == 4){
						$bg = '#91c75f';// レッスン
					}else if($ary[$p]['department'] == 5){
						$bg = '#55b7cd';// セッション
					}
					$start_time = $ary[$p]['start_hour'].':'.$ary[$p]['start_minute'];
					$end_time = $ary[$p]['end_hour'].':'.$ary[$p]['end_minute'];
					$text = '【'.$ary[$p]['company'].'】<div>'.$ary[$p]['name'].'</div><div>'.$ary[$p]['tel'].'</div><div>'.$start_time.' 〜 '.$end_time.'</div><div>'.$ary[$p]['price'].'</div>';
					$style_txt = ' style="background: '.$bg.'; height: '.($ary[$p]['total'] / 5 * 10).'px;"';
				
					$Hbox = '<div'.$style_txt.'><div class="txt">'.$text.'</div></div>';
					$timeScheduleDef[$i] .= '<tr><td class="'.$p.' on data'.$ary[$p]['id'].'">'.$Hbox.'<div class="caption">'.sprintf('%02d', $q).' 分</div></td></tr>';
					$q = $ary[$p]['end_minute'];
					if($ary[$p]['end_minute'] == '00'){
						$q = 0;
					}
			
					$v += $ary[$p]['total'] / 5;
					$p = $ary[$p]['end_hour'];
					$v--;
						
				}else{
					$timeScheduleDef[$i] .= '<tr><td class="'.$p.'"><div class="caption">'.sprintf('%02d', $q).' 分</div></td></tr>';
					$q += 5;
					
				}
			}else{
			
				if($q == 55){
					$timeScheduleDef[$i] .= '<tr><td class="'.$p.' just"><div class="caption">'.sprintf('%02d', $q).' 分</div></td></tr>';
					$q = 0;
					$p++;
				}else{
					$timeScheduleDef[$i] .= '<tr><td class="'.$p.'"><div class="caption">'.sprintf('%02d', $q).' 分</div></td></tr>';
					$q += 5;
				}
			}
//echo 'Q='.$q.'　　P='.$p.'<br />';
		}	
	}
for($i = 10; $i <= 23; $i++){  //`時間数
		$timelineDef .= '<tr><th>'.$i.'時</th></tr>';
}	
for($t = 0; $t < $display_num; $t++){
		$table .= '<div class="onedDayTable">
					<table class="dateSchedule">
						<tr><th colspan="4"><span>'.$getWeekAry[$t].'</span> ('.$youbiAry[$t].')</th></tr>
						<tr class="room">'.$room.'</tr>
					</table>
					<table class="Schedule" id="'.$t.'">
						'.$timeScheduleDef[$t].'
					</table>
				</div>';
}
?>