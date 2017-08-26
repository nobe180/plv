<?php
	$fun = substr(date('i'), 0, 1);
	$content_txt = '<link rel="stylesheet" type="text/css" href="/admin/system/midi_password/index.css" />
					<p>MIDI検定4級試験のパスワードは <span id="pass">'.substr(md5('PLV'.date('ynjH').$fun),0,8).'</span> です。</p>
					<p class="notice">10分置きにパスワードが変更します。</p>';
?>