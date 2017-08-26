<?php 
	require_once($_SERVER[ 'DOCUMENT_ROOT' ] . '/program/php/option.php');
	require_once('php/function.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
		<title>千葉の中心部、芸術の発信地　PPC アートサロン</title>
		<meta content="PLV,ライブハウス,千葉,音楽,ジャズ,レンタルスペース,ホール" name="keywords">
		<meta content="PLV music networkの運営する、千葉県千葉市のライブハウス・レンタルスペースです。" name="description">
		<meta name="format-detection" content="telephone=no">
		<link rel="icon" href="images/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="stylesheets/common.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/header.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/menu.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/pickup.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/about.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/schdule.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/price.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/equipment.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/order_menu.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/news.css" />
		<link rel="stylesheet" type="text/css" href="stylesheets/footer.css" />
		<link rel="stylesheet" media="screen and (max-width: 640px)" href="stylesheets/index_sp.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="javascript/common.js"></script>
		<script type="text/javascript" src="javascript/menu.js"></script>
		<script type="text/javascript" src="javascript/pickup.js"></script>
		<script type="text/javascript" src="javascript/schedule.js"></script>
		<script type="text/javascript" src="javascript/equipment.js"></script>
		<script type="text/javascript" src="javascript/news.js"></script>
	</head>

	<body>

	<body>
		<?php require_once('php/header.php'); ?>
		<?php require_once('php/menu.php'); ?>
		<?php require_once('php/pickup.php'); ?>
		<?php require_once('php/about.php'); ?>
		<?php require_once('php/schdule.php'); ?>
		<?php require_once('php/price.php'); ?>
		<?php require_once('php/equipment.php'); ?>
		<?php require_once('php/order_menu.php'); ?>
		<?php require_once('php/news.php'); ?>
		<?php require_once('php/footer.php'); ?>
	</body>
</html>