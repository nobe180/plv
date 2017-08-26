<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
	if($_SESSION['adminID']){ 
		//url('/admin');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
		<meta NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW" />
		<link rel="stylesheet" type="text/css" href="../index.css" />
		<link rel="stylesheet" type="text/css" href="index.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="<?= $dir; ?>program/javascript/prefixfree.min.js"></script>
		<script type="text/javascript" src="index.js"></script>
		<title>講師専用ページ</title>
	</head>
	<body>

		<h1>PLV music network</h1>
		<div id="contents">
			<div class="leftCts">講師専用ログイン</div>
			<form class="rightCts" method="POST" autocomplete="off">
				<p>Instructor ID<br /><input type="text"  name="id" id="id"></p>
				<p>Password<br /><input type="password"  name="pass" id="pass"></p>
				<p class="button"><input type="button" value="Login" name="submit" /></p>
			</form>
		</div>
	
	</body>
</html>