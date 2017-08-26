<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	$ID=$_POST['id'];
	$TXT=$_POST['txt'];

	$sql="select T1.midi_ID, COUNT(T2.midi_ID) as bangou from midi_licence as T1, midi_licence as T2 where T1.midi_ID='".$ID."' and T1.midi_ID >= T2.midi_ID group by T1.midi_ID";
	$re=$db->run($sql);
	$nowNumber = $re[0]['bangou']-1;

	$sql = "select * from midi_licence order by midi_ID ASC";
	$re = $db->run($sql);
	$data = array();
	$data[0] = 0;
	if($TXT=='prevBtn') $ChangeNumber = $nowNumber-1;
	else if($TXT == 'nextBtn') $ChangeNumber = $nowNumber+1;
	else if($TXT == 'listSelect') $ChangeNumber = $nowNumber;

	if($ChangeNumber == $data[0]) $data[0] = 1;
	else if($ChangeNumber == (count($re)-1)) $data[0] = 2;

	$data[1] = $re[$ChangeNumber];
		$sql = "select * from online where online_ID='".$re[$ChangeNumber]['midi_U_ID']."'";
		$re = $db->run($sql);
	$data[2] = $re[0];

	echo json_encode($data);
?>