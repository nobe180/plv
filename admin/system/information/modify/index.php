<?php require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php'); ?>
<?php require_once('../../header.php'); ?>
<!-- ************* コンテンツ ************* -->

<script src="index.js"></script>
<link rel="stylesheet" href="index.css">

			<h1>新着情報</h1>
			<article id="wrapper">
<?php
	$sql = "select * from information where ID='".$_GET['No']."'";
	$re = $db->run($sql);
	if($re[0]['flag'] == 0){
		$news = 'selected=selected';
	}else if($re[0]['flag'] == 1){
		$blog = 'selected=selected';
	}else if($re[0]['flag'] == 2){
		$plv = 'selected=selected';
	}else if($re[0]['flag'] == 3){
		$ppc = 'selected=selected';
	}
?>
				<form name="form" action="check.php" method="POST">
					<input type="hidden" name="id" value="<?=  $re[0]['ID'] ;?>" />
					<p>
						記事選択<br />
						<select id="select" name="select">
							<option value="2" <?= $plv; ?>>PLV音楽院</option>
							<option value="3" <?= $ppc; ?>>PPC アートサロン</option>
							<option value="0" <?= $news; ?>>お知らせ</option>
							<option value="1" <?= $blog; ?>>ブログ</option>
						</select>
					</p>
					<p id="title">タイトル<br /><input type="text" name="title" value="<?= $re[0]['title'] ?>" /></p>
					<p>日付<br /><input type="text" name="date" class="datepicker" value="<?= $re[0]['date'] ?>" /></p>
					<p>公開設定　
						<label><input type="radio" name="show" value="1"<?php if($re[0]['show']==1){echo' checked="checked"';} ?> class="show" />公開</label>　　
						<label><input type="radio" name="show" value="0"<?php if($re[0]['show']==0){echo' checked="checked"';} ?> class="show" />下書き</label>
					</p>
					<p>内容<br /><textarea name="content"><?= $re[0]['content'] ?></textarea></p>
					<p class="txt_right">
						<input type="submit" value="更新" name="modify" class="btn" />　
						<input type="submit" value="削除" name="delete" class="delete btn" />
					</p>
				</form>
			</article>




<!-- ************* ここまで ************* -->
<?php require_once('../../footer.php'); ?>