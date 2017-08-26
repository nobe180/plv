<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');
$sql = "select * from information where flag<>'1' and del='0' and `show`='1' order by date DESC";
$info = $db->run($sql);
for($i = 0; $i < count($info); $i++){
	$flag_txt = '';
	if($info[$i]['flag'] == '2'){
		$flag_txt = '<div class="nclass">音楽院</div>';	
	}else if($info[$i]['flag'] == '3'){
		$flag_txt = '<div class="nclass">PPC</div>';	
	}
	$result .= '<li>
         <span>'
            .$info[$i]['date'].'<br>'
            .nl2br($info[$i]['title']).'<br>
          </span>
          <div class="ndet">'.nl2br($info[$i]['content']).'</div>
          '.$flag_txt.'
		 </li>';
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <link href="css/news.css" media="screen and (min-width: 600px)" rel="stylesheet">
    <link href="css/sp.css" media="screen and (max-width: 599px)" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One|Libre+Baskerville|Noto+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/earlyaccess/mplus1p.css" rel="stylesheet">
    <title>ニュース</title>
  </head>
  <body>
    <div id="news1">
        <ul>
		<li><h2>NEWS</h2></li>
			<?= $result; ?>
		</ul>

  </body>
</html>
