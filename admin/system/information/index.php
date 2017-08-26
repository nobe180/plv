<?php require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php'); ?>
<?php require_once('../header.php'); ?>
<!-- ************* コンテンツ ************* -->


<script src="index.js"></script>
<link rel="stylesheet" href="index.css">

			<h1>新着情報</h1>
			<article id="wrapper">
<?php		
	$select_ID = 0;	
	if($_GET['ID']){
		if($_GET['ID'] == '0'){
			$news_checked = 'checked';
			$style_name = 'news';
		}else if($_GET['ID'] == '1'){
			$blog_checked = 'checked';
			$style_name = 'blog';
		}else if($_GET['ID'] == '2'){
			$plv_checked = 'checked';
			$style_name = 'plv';
		}else if($_GET['ID'] == '3'){
			$ppc_checked = 'checked';
			$style_name = 'ppc';
		}
		$select_ID = $_GET['ID'];
	}else {
		$news_checked = 'checked';
		$style_name = 'news';
	}
				
	$tab_style = '<style type="text/css">.info_'.$style_name.' {display: block; !important}</style>';
	$result = $_POST['result'];
	if ($result != NULL){
		$ids = explode(",",$result);
		for ($i = 0; $i < count($ids); $i++){
			$id = $ids[$i]+0;
			$sql = "update information set `order`='".$i."' where ID='".$id."'";
			$re = $db->run($sql);
		}
	}

	$sql="select * from information where del=0 order by date DESC";
	$re = $db->run($sql);

	for($i=0;$i<count($re);$i++){
		$show = '公開中';
		if($re[$i]['show']==0){
			$show = '<span class="font_style">下書き</span>';
		}
		
		$html_tag = $re[$i]['content'];
		$sub_title = '';

		if($re[$i]['flag'] == 0){
			$table_news .= '<li id="'.$re[$i]['ID'].'"><table class="edit"><tr>
			<td width="75"><a href="modify/index.php?No='.$re[$i]['ID'].'"><input type="submit" value="編 集" class="btn" /></a></td>
			<td width="150">'.$re[$i]['date'].'</td>
			<td>'.$re[$i]['title'].'</td>
			<td width="100">'.$show.'</td>
		</tr></table></li>';
			
		}else if($re[$i]['flag'] == 1){
			$table_blog .= '<li id="'.$re[$i]['ID'].'"><table class="edit"><tr>
			<td width="75"><a href="modify/index.php?No='.$re[$i]['ID'].'"><input type="submit" value="編 集" class="btn" /></a></td>
			<td width="150">'.$re[$i]['date'].'</td>
			<td>'.$re[$i]['title'].'</td>
			<td width="100">'.$show.'</td>
		</tr></table></li>';
			
		}else if($re[$i]['flag'] == 2){
			$table_plv .= '<li id="'.$re[$i]['ID'].'"><table class="edit"><tr>
			<td width="75"><a href="modify/index.php?No='.$re[$i]['ID'].'"><input type="submit" value="編 集" class="btn" /></a></td>
			<td width="150">'.$re[$i]['date'].'</td>
			<td>'.$re[$i]['title'].'</td>
			<td width="100">'.$show.'</td>
		</tr></table></li>';
			
		}else if($re[$i]['flag'] == 3){
			$table_ppc .= '<li id="'.$re[$i]['ID'].'"><table class="edit"><tr>
			<td width="75"><a href="modify/index.php?No='.$re[$i]['ID'].'"><input type="submit" value="編 集" class="btn" /></a></td>
			<td width="150">'.$re[$i]['date'].'</td>
			<td>'.$re[$i]['title'].'</td>
			<td width="100">'.$show.'</td>
		</tr></table></li>';
		}
		$matches[3] = '';
	}
?>
<style type="text/css">.info_table {display: none;}</style>
<?= $tab_style; ?>
				<div id="refine_select">
					<a href="update/?ID=<?= $select_ID; ?>"><img src="/program/images/material/new_page.png" title="新規" id="new_list" /></a>
				</div>
				<div class="tab_box">
					<label class="check_design radio_box"><input type="radio" name="info" value="2" <?= $plv_checked; ?> /><span class="lever">PLV音楽院</span></label>
					<label class="check_design radio_box"><input type="radio" name="info" value="3" <?= $ppc_checked; ?> /><span class="lever">PPCアートサロン</span></label>
					<label class="check_design radio_box"><input type="radio" name="info" value="0" <?= $news_checked; ?> /><span class="lever">お知らせ</span></label>
					<label class="check_design radio_box"><input type="radio" name="info" value="1" <?= $blog_checked; ?>/><span class="lever">ブログ</span></label>
				</div>
				<table id="head">
					<tr align="center">
						<th width="75">ID</th>
						<th width="150">日付</th>
						<th>タイトル</th>
						<th width="100">公開設定</th>
					</tr>
				</table>
				<ul class="order info_news info_table"><?= $table_news; ?></ul>
				<ul class="order info_plv info_table"><?= $table_plv; ?></ul>
				<ul class="order info_ppc info_table"><?= $table_ppc; ?></ul>
				<ul class="order info_blog info_table"><?= $table_blog; ?></ul>

<!-- ドラッグ・アンド・ドロップで順番入れ替え -->
				<!--<form action="./#order_change" method="post" id="order_change">
					<input type="hidden" id="result" name="result" />
					<p class="button"><input type="submit" id="submit" value="並び順を保存する" /></p>
				</form>-->
			</article>

<!-- ************* ここまで ************* -->
<?php require_once('../footer.php'); ?>
