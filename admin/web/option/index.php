<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	admin_check();
	$sql = "select * from plv_option";
	$re = $db->run($sql);
?>
<?php require_once('../common/header.php'); ?>
<!-- ************* コンテンツ ************* -->

	<input type="hidden" name="idname" value="option" />
	<div style="margin-bottom:40px;">
		初期メタワード ： <textarea name="keywords"><?= $re[0]['keywords']; ?></textarea>
		初期メタデスクリプション ： <textarea name="description"><?= $re[0]['description']; ?></textarea>
		サイトメールアドレス ： <input type="text" name="mail" value="<?= $re[0]['mail']; ?>" />
	</div>
	<div style="margin-bottom:40px;">
		専攻ワード ： <textarea name="major"><?= $re[0]['major']; ?></textarea>
	</div>


<!-- ************* ここまで ************* -->
<?php require_once('../common/footer.php'); ?>