<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	admin_check();

	$sql = "select * from posts where relation='faq' order by sort ASC";
	$contents = $db->run($sql);	

	//$num = count($contents)-1;
	$num = count($contents);

	$sql = "select * from faq order by flag ASC";
	$re = $db->run($sql);

	$flag_num = $re[0]['flag'];
	for($i = 0; $i <= count($contents); $i++){
		$hoge[] = $contents[$i]['sort'];
		
	}
//重複を削除しただけの配列
$hogehoge = array_unique($hoge);
//キーを振りなおした配列
$hoge = array_values($hogehoge);
for($i = 0; $i < count($hoge); $i++){
//$test .= $hoge[$i].'<br />';
}


for($i = 0; $i <= count($re); $i++){
	if($re[$i]['flag']){
		$flag_ary[] = $re[$i]['flag'];	
	}
	
}

$flag_ary_del = array_unique($flag_ary);
$flag_ary = array_values($flag_ary_del);



	for($i = 0; $i < $num; $i++){
		$sort = $contents[$i]['sort'];
		$data_class = ' data_';
		
		for($v = 1; $v <= 10; $v++){
			if($contents[$i]['content'.$v] !== '' && $contents[$i]['content'.$v] !== 'FAQ_list'){
				$result1[$i] .= '<textarea name="content'.$contents[$i]['sort'].'_'.$v.'">'.$contents[$i]['content'.$v].'</textarea>';	
			}
			
			if($contents[$i]['content'.$v] == 'FAQ_list'){
				$data_class = ' faq_data';
				$faq_contents = '<input type="hidden" id="faq_list_" value="FAQ_list" />';
				//alert(count($faq));<input type="hidden" name="num" value="'.$contents_num.'" />
				for($t = 0; $t < count($flag_ary); $t++){
					$sql = "select * from faq where flag='".$flag_ary[$t]."' order by flag desc, ID ASC";
					$re = $db->run($sql);
					$flag_title = '<dl class="faq_title_box"><dt></dt><dt><input type="text" name="sort'.$re[0]['flag'].'" value="'.$re[0]['flag'].'" class="sort" /></dt><dd><input type="text" class="faq_title" name="" value="'.$re[0]['flag_name'].'" /></dd><dt>削除</dt></dl>';
					
					for($j = 0; $j < count($re); $j++){
						$del = '<input type="submit" name="'.$re[$j]['ID'].'" value="削除" class="del" />';
						$flag_faq .= '<tr class="faq_'.$flag_ary[$t].'_'.($j+1).'"><th rowspan="2">質問<span class="del_num">'.($j+1).'</span>'.$del.'</th><td class="blue">Q</td><td><textarea name="Q_'.$flag_ary[$t].'_'.($j+1).'" class="q_txt">'.$re[$j]['question'].'</textarea></td></tr><tr><td class="red">A</td><td><textarea name="A_'.$flag_ary[$t].'_'.($j+1).'">'.$re[$j]['answer'].'</textarea></td></tr>';
					}
					$faq_contents .= $flag_title.'<div class="faq_box flag_faq_'.$flag_ary[$t].'"><table class="faq">'.$flag_faq.'</table><div class="add_btn">追加</div></div>';
					$flag_title ='';
					$flag_faq = '';
				}
				$faq_contents .= '<div class="faq_add_btn">FAQタイトル追加</div>';
				$class_ = ' faq';
			}
		}
		
		$result .= '<div class="contents_data clearfix'.$data_class.'"><dl class="title_box"><dt><input type="hidden" value="'.$contents[$i]['ID'].'" /><input type="text" name="sort'.$sort.'" value="'.$sort.'" class="sort" /></dt><dd><input type="text" name="title'.$sort.'" value="'.$contents[$i]['inner_title'].'" /></dd><dt>削除</dt></dl>'.$result1[$i].$faq_contents.'<p class="txt_right'.$class_.'"><input type="button" value="本文追加" class="addBtn" /></p></div>';
		$faq_contents = '';
		$class_ = '';
	}

	$text = '<input type="hidden" name="idname" value="faq" />
			<input type="hidden" name="faq_title_index" value="'.count($flag_ary).'" />
						<div style="margin-bottom:40px;">
							ページタイトル ： 
							<input type="text" name="pagetitle" value="'.$contents[0]['page_title'].'" />
							メタワード ： 
							<textarea name="keywords">'.$contents[0]['keywords'].'</textarea>
							メタデスクリプション ： 
							<textarea name="description">'.$contents[0]['description'].'</textarea>
						</div>
						<input type="text" name="contents_title" value="'.$contents[0]['contents_title'].'" class="contents_title" />
						'.$result.'
						<div class="midashi_btn">見出し追加</div>
						<input type="hidden" name="num" value="'.$contents_num.'" />';
?>
<?php require_once('../common/header.php'); ?>
<!-- ************* コンテンツ ************* -->

	<?= $test; ?>
	<?= $text; ?>
<div id="test2"></div>
<!-- ************* ここまで ************* -->
<?php require_once('../common/footer.php'); ?>