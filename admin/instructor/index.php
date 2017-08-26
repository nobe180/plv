<?php require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php'); ?>
<?php require_once('header.php'); ?>
<!-- ************* コンテンツ ************* -->


<div id="container">
	<h1>ようこそ <?= $_SESSION['instructor_name'] ; ?> 先生</h1>
</div>


<!-- ************* ここまで ************* -->
<?php require_once('footer.php'); ?>