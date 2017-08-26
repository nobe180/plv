<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	admin_check();
	$relation = $_GET['relation'];

	$sql = "select * from posts where relation='".$relation."' order by sort ASC";
	$contents = $db->run($sql);	
	$num = count($contents);

	for($i = 0; $i <= count($contents); $i++){
		$hoge[] = $contents[$i]['sort'];
	}
	//重複を削除しただけの配列
	$hogehoge = array_unique($hoge);
	//キーを振りなおした配列
	$hoge = array_values($hogehoge);

	for($i = 0; $i < $num; $i++){
		$sort = $contents[$i]['sort'];
		for($v = 1; $v <= 10; $v++){
			if($contents[$i]['content'.$v] !== ''){
				$result1[$i] .= '<textarea name="content'.$contents[$i]['sort'].'_'.$v.'">'.$contents[$i]['content'.$v].'</textarea>';	
			}
		}
		$result .= '<div class="contents_data"><dl class="title_box"><dt><input type="hidden" value="'.$contents[$i]['ID'].'" /><input type="text" name="sort'.$sort.'" value="'.$sort.'" class="sort" /></dt><dd><input type="text" name="title'.$sort.'" value="'.$contents[$i]['inner_title'].'" /></dd><dt>削除</dt></dl>'.$result1[$i].'<p class="txt_right"><input type="button" value="本文追加" class="addBtn" /></p></div>';
	}

	$text = '<input type="hidden" name="idname" value="'.$relation.'" />
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

<!-- ************* ここまで ************* -->
<?php require_once('../common/footer.php'); ?>