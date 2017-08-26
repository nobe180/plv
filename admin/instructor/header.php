<?php
	if(!isset($_SESSION['instructor_ID'])){
		url('/admin/instructor/login');
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
		<meta NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW" />
		<link rel="icon" href="/program/images/icon/plv_favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/admin/instructor/index.css" />
		<link rel="stylesheet" media="screen and (max-width: 640px)" href="/admin/instructor/index_sp.css">
		<link rel="stylesheet" type="text/css" href="/program/javascript/fullcalendar/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="/program/javascript/fullcalendar/fullcalendar.min.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="/admin/instructor/index.js"></script>
		<script type="text/javascript" src="/program/javascript/prefixfree.min.js"></script>
		<script type="text/javascript" src="/program/javascript/fullcalendar/moment.min.js"></script>
		<script type="text/javascript" src="/program/javascript/fullcalendar/fullcalendar.min.js"></script>
		<script type="text/javascript" src="/program/javascript/fullcalendar/ja.js"></script>
		<title>講師専用ページ</title>
	</head>

	<body>
		<div id="wrapper" class="clearfix">
			<header>
				<h1>PLV music network</h1>
				<div class="btn-menu sp"><span></span><span></span><span></span></div>
				<h2 class="pc">講師MENU</h2>
				<ul class="clear">
					<li><a href="/admin/instructor/reservation">スケジュール登録</a></li>
					<li><a href="/admin/instructor/password">パスワードの変更</a></li>
					<li><a href="/admin/instructor/logout">ログアウト</a></li>
				</ul>
			</header>