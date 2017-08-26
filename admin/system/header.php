<?php
	if(!isset($_SESSION['adminID'])){
		url('/admin/login');
	}
	$$menu = '';
	if($_SESSION['adminID'] == 'admin') {
		$menu = '<li><a href="/admin/web">Webサイト編集</a></li>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW" />
		<link rel="stylesheet" type="text/css" href="/admin/system/index.css" />
		<link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
		<link rel="stylesheet" href="/program/stylesheets/tablesorter.css">
		<style type="text/css">
    		/* 土日を赤にする */
			.ui-datepicker-week-end, .ui-datepicker-week-end a.ui-state-default{color:red;}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
		<script type="text/javascript" src="https://jpostal-1006.appspot.com/jquery.jpostal.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
		<script src="/program/javascript/prefixfree.min.js"></script>
		<script src="/program/javascript/jquery.tablesorter.min.js"></script>
		<script src="/program/javascript/autosize.min.js"></script>
		<script src="/admin/system/index.js"></script>
		<title>管理者専用ページ</title>
	</head>

	<body>
		<header class="non_print">
			<h1>PLV music network</h1>
			<h2>管理者MENU</h2>
			<a href="/admin/system"><span class="icon"><img src="/program/images/material/home_2.png" title="管理者メインページ" /></a></span>
			<a href="/admin/logout"><span class="icon"><img src="/program/images/material/logout.png" title="ログアウト" /></span></a>
			
			<ul class="clear">
				<?= $menu; ?>
				<li><a href="/admin/system/information">新着情報</a></li>
			</ul>
			<ul class="clear">
				<li id="workers">スタッフ登録と変更</li>
				<li id="staff_list">スタッフ一覧</li>
				<li id="member_list">会員情報</li>
				<li id="mail_list">メールリスト</li>
				<li id="studio_schedule">スタジオスケジュール</li>
				<li id="studio_payment">スタジオ支払状況</li>
				<li id="online_shedule">オンラインスケジュール</li>
				<li id="online_payment">オンライン支払状況</li>
				<li id="instructor_schedule">講師スケジュール</li>
			</ul>
			<ul class="clear">
				<li id="school_work">PLV音楽院業務</li>
				<li id="repair_work">楽器リペア業務</li>
				<li id="agency_work">演奏派遣業務</li>
				<li id="prduce_work">楽曲制作業務</li>
			</ul>
			<ul class="clear">
				<li id="midi_password">MIDI検定4級試験パスワード生成</li>
				<li id="midi_license">MIDI検定4級試験受講者リスト</li>
			</ul>
		</header>

		<div id="container" class="non_print">