<?php
	if(!isset($_SESSION['adminID'])){
		url('/admin/login');
	}
	$dir = '/admin/web/';
?>

<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<meta NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW" />
		<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
		<link rel="icon" href="/images/icon/plv_favicon.ico" />
		<!--<link rel="stylesheet" type="text/css" href="/stylesheets/different.css" />-->
		<link rel="stylesheet" type="text/css" href="<?= $dir; ?>common/index.css" />
		<link rel="stylesheet" type="text/css" href="index.css" />
		<link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
		<script type="text/javascript" src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
		<script src="<?= $dir; ?>common/index.js"></script>
		<script src="/javascript/prefixfree.min.js"></script>
		<script src="/program/javascript/autosize.min.js"></script>
		<script src="index.js"></script>
		<title>管理者専用ページ</title>

	</head>
	<body>
		<div id="wrapper" class="clearfix">
			<header>
				<h1>PLV music network</h1>
				<h2>Webサイト編集MENU</h2>
				<a href="/admin/system"><span class="icon"><img src="/program/images/material/home_2.png" title="管理者メインページ" /></a></span>
				<a href="logout"><span class="icon"><img src="/program/images/material/logout.png" title="ログアウト" /></span></a>
				<ul style="clear:left;">
					<!--<li id="news">新着情報</li>-->
				</ul>
				<ul class="edit">
					<li><a href="<?= $dir; ?>temp/?relation=top">トップ</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=concept">理念</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=system">システムについて</a></li>
					<li><a href="<?= $dir; ?>faq">FAQ</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=access">アクセス</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=contact">お問い合わせ</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=outline">事業概要</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=law">特定商取引法に基づく表記</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=privacy">プライバシーポリシー</a></li>
				</ul>
				<ul class="edit">
					<li><a href="<?= $dir; ?>temp/?relation=school">PLV音楽院</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=studio">レンタルスタジオ</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=repair">楽器リペア</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=agency">演奏派遣</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=produce">楽曲制作</a></li>
				</ul>
				<ul class="edit">
					<li><a href="<?= $dir; ?>temp/?relation=instructor">講師紹介</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=method">バークリーメソッド</a></li>
				</ul>
				<ul class="edit">		
					<li><a href="<?= $dir; ?>temp/?relation=guitar">ギター</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=bass">ベース</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=piano">ピアノ＆キーボード</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=vocal">ボーカル＆ボイストレーニング</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=drums">ドラム</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=saxophone">サックス</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=trumpet">トランペット</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=trombone">トロンボーン</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=shinobue">篠笛</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=others">その他の管楽器</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=compose">音楽理論（アドリブ・作編曲）</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=ear_training">イヤートレーニング</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=dtm">DTM</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=score">譜面作成</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=midi">MIDI検定</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=exam">音大受験・通信教育</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=senzoku">洗足学園音楽大学</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=abroad">音楽留学</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=friend">友達と始めるビギナーレッスン</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=ensemble">アンサンブル</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=lab">ラボ</a></li>
					<li><a href="<?= $dir; ?>temp/?relation=online">オンラインレッスン</a></li>
					
				</ul>
				<ul>
					<li><a href="<?= $dir; ?>option">オプション</a></li>
				</ul>
			</header>

			<div id="container">
				<div id="test"></div>