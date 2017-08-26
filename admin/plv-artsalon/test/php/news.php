<?php
	$sql = "select * from information where flag<>'1' and del='0' and `show`='1' order by date DESC";
	$re = $db->run($sql);

	foreach ($re as $key => $value) {
		$flag_txt = '';
		if($value['flag'] == '2'){
			$flag_txt = '<p class="flag_plv">PLV音楽院</p>';	
		}else if($value['flag'] == '3'){
			$flag_txt = '<p class="flag_ppc">アートサロン</p>';
		}else if($value['flag'] == '0'){
			$flag_txt = '<p class="flag_">お知らせ</p>';
		}
		
		$news_result .= '<div class="news_list">
						'.$flag_txt.'
						<p>'.$value['date'].'</p>
						<p class="news_data" data="'.$value['ID'].'">【'.nl2br($value['title']).'】<span class="arrow_"><span></span><span></span><span></span></span></p>
						</div>';
	}

?>
		<section id="news" class="main_style">
			<div class="title"><img src="images/news.png" alt="News"/></div>
			<p>※ タイトルをくクリックすると詳細が表示されます。</p>
			<div id="news_wrap">
				<div id="news_prev"><div class="news_dammy"></div></div>
				<div id="news_box">
					<?= $news_result; ?>
				</div>
				<div id="news_next"><div class="news_dammy"></div></div>
			</div>
			
			<div id="news_modal">
				<div class="txt_right">
					<img src="http://plv-artsalon.com/schedule_data/images/close.png" id="closeImg" title="閉じる" class="non_print" />
				</div>
				<div class="news_detail">
					<p></p>
					<h2></h2>
					<p></p>
				</div>
			</div>
		</section>