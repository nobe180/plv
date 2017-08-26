<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	$instructor_ID = $_SESSION['instructor_ID'];
	$instructor_name = $_SESSION['instructor_name'];
?>
<?php require_once('../header.php'); ?>
<!-- ************* コンテンツ ************* -->

		<link rel="stylesheet" type="text/css" href="index.css" />
		<script type="text/javascript" src="index.js"></script>
		<input type="hidden" name="instructor_id" value="<?= $instructor_ID ?>" />
		<div id="container">
		
			<h1><span>パスワードの変更</span></h1>
			<dl>
				<dt>パスワード</dt>
				<dd>
						現在のパスワード　<input type="password" name="pass_now" value="" /><br />
						新しいパスワード　<input type="password"  name="pass_new" value="" /><br />
							 　　　　再度入力　<input type="password" name="pass_new_confirm" value="" /><br />
				</dd>
			</dl>
			<p class="txt_center btn_box">
				<input type="button" id="cancel_btn" value="キャンセル" class="btn">　
				<input type="button" id="modify_btn" value="更新" class="btn">
			</p>
		</div>


<!-- ************* ここまで ************* -->
<?php require_once('../footer.php'); ?>
