<?php require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php'); ?>
<?php require_once('../../header.php'); ?>
<!-- ************* コンテンツ ************* -->


<?php
	if($_GET['ID']){
		if($_GET['ID'] == '0'){
			$news_selected = 'selected';
		}else if($_GET['ID'] == '1'){
			$blog_selected = 'selected';
		}else if($_GET['ID'] == '2'){
			$plv_selected = 'selected';
		}else if($_GET['ID'] == '3'){
			$ppc_selected = 'selected';
		}
	}
?>
<script src="../modify/index.js"></script>
<link rel="stylesheet" href="../modify/index.css">

			<h1>新着情報</h1>
			<article id="wrapper">
				<form name="form" action="check.php" method="POST">
					<input type="hidden" name="id" value="" />
					<p>
						記事選択<br />
						<select id="select" name="select">
							<option value="2" <?= $plv_selected; ?>>PLV音楽院</option>
							<option value="3" <?= $ppc_selected; ?>>PPC アートサロン</option>
							<option value="0" <?= $news_selected; ?>>お知らせ</option>
							<option value="1" <?= $blog_selected; ?>>ブログ</option>
						</select>
					</p>
					<p id="title">タイトル<br /><input type="text" name="title" value="" /></p>
					<p>日付<br /><input type="text" name="date" class="datepicker" value="" /></p>
					<p>公開設定　
						<label><input type="radio" name="show" value="1" />公開</label>　　
						<label><input type="radio" name="show" value="0" checked="checked" />下書き</label>
					</p>
					<p>内容<br /><textarea name="content"></textarea></p>
					<p class="txt_right"><input type="submit" value="登録" name="update" class="btn" /></p>
				</form>
			</article>



<!-- ************* ここまで ************* -->
<?php require_once('../../footer.php'); ?>