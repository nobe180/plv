<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	admin_check();
?>
<?php require_once('../common/header.php'); ?>
<!-- ************* コンテンツ ************* -->


	<div id="test"></div>
	<input type="hidden" name="idname" value="article" />
	見出し ： <h1><input type="text" name="new_title" value="" /></h1>
	見出し本文1 ： <textarea name="content1"></textarea>
	見出し本文2 ： <textarea name="content2"></textarea>
	見出し本文3 ： <textarea name="content3"></textarea>
	見出し本文4 ： <textarea name="content4"></textarea>
	見出し本文5 ： <textarea name="content5"></textarea>
	関連 ： <select id="relation"></select>


<!-- ************* ここまで ************* -->
<?php require_once('../common/footer.php'); ?>