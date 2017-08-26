<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	$item = $_POST['item'];
	$string = $_POST['string'];
	$refine1 = array('school', 'studio', 'repair', 'agency', 'produce', 'other');
	$refine2 = array('full', 'associate', 'online', 'studio_', 'withdrawal', 'other_');
	$user_id = $_POST['user_id'];
	$where = ' where 1';
	$recess = " and (recess='0' or recess='".$_POST['refine_recess']."')";
	if($user_id != ''){
		$where .= " and ID='".$user_id."'";
		if($user_id == '0'){
			$data['new_page'] = '1';
		}else{
			$data['new_page'] = '0';
		}
	}else{
		$refine = refine($refine1).refine($refine2);
		if($refine == ''){
			$recess = " and recess='".$_POST['refine_recess']."'";
		}
		if($string != ''){
			if($item == 'name, furigana'){
				$string = Roman2Kana($string);
			}
			$string = str_replace("　", " ", $string);//全角空白があったら半角空白にそろえる
			$str_array = preg_split("/[ ]+/",$string);//空白文字ﾃﾞ検索ワｰドを分割	
			foreach($str_array as $str_array_element ){//ワｰドごとﾆ検索条件を追加
				$where_search = " and concat_ws(char(0), ".$item.") LIKE '%{$str_array_element}%'";
			}
		}
		$where = $where.$refine.$recess.$where_search;
	}
	
	$sql = "select * from user_master".$where;
	$data['array'] = $db->run($sql);
	$data['test'] = $string;

	print json_encode($data);


	function refine($a){
		for($i = 0; $i < count($a); $i++){
			if($_POST['refine_'.$a[$i]] == '1'){ 
				$where_refine .= " ".$a[$i]."='".$_POST['refine_'.$a[$i]]."' or ";
			}
		}
		if($where_refine){
			$where_refine = rtrim($where_refine, 'or ');
			$where_refine = ' and ('.$where_refine.')';
		}
		return $where_refine;
	}	

	function Roman2Kana($i) {
    $s =array('vv','kk','gg','ss','zz'
             ,'jj','tt','dd','hh','ff'
             ,'bb','pp','mm','yy','rr','ww'
             ,'cc','xx','ll',"n'",'nn'
             ,'xtsa','xtsi','xtsu','xtse','xtso'
             ,'xtu','ltsu','ltu'
             ,'kya','kyi','kyu','kye','kyo'
             ,'sya','syu','sye','syo'
             ,'sha','shi','shu','she','sho'
             ,'cha','chi','chu','che','cho'
             ,'tsa','tsi','tsu','tse','tso'
             ,'tha','thi','thu','the','tho'
             ,'tya','tyi','tyu','tye','tyo'
             ,'nya','nyu','nyo'
             ,'hya','hyu','hyo'
             ,'mya','myu','myo'
             ,'rya','ryu','ryo'
             ,'wha','whi','whe','who'
             ,'wyi','wye'
             ,'gya','gyu','gyo'
             ,'zya','zyu','zyo'
             ,'bya','byu','byo'
             ,'pya','pyu','pyo'
             ,'dha','dhi','dhu','dhe','dho'
             ,'dya','dyi','dyu','dye','dyo'
             ,'xya','lya','xyu','lyu','xyo','lyo'
             ,'xwa','lwa','xke','lke'
             ,'xa','xi','xu','xe','xo'
             ,'la','li','lu','le','lo'
             ,'ka','ki','ku','ke','ko'
             ,'sa','si','su','se','so'
             ,'ta','ti','tu','te','to'
             ,'na','ni','nu','ne','no'
             ,'ha','hi','hu','he','ho'
             ,'fa','fi','fu','fe','fo'
             ,'ma','mi','mu','me','mo'
             ,'ya','yu','yo','yi','ye'
             ,'ra','ri','ru','re','ro'
             ,'wa','wi','wu','we','wo'
             ,'ga','gi','gu','ge','go'
             ,'za','zi','zu','ze','zo'
             ,'ja','ji','ju','je','jo'
             ,'da','di','du','de','do'
             ,'ba','bi','bu','be','bo'
             ,'va','vi','vu','ve','vo'
             ,'pa','pi','pu','pe','po'
             ,'n','a','i','u','e','o','-');

    $r =array('ｯv','ｯk','ｯg','ｯs','ｯz'
             ,'ｯj','ｯt','ｯd','ｯh','ｯf'
             ,'ｯb','ｯp','ｯm','ｯy','ｯr','ｯw'
             ,'ｯc','ｯx','ｯl','ﾝ','ﾝ'
             ,'ｯｧ','ｯｨ','ｯ'  ,'ｯｪ','ｯｫ'
             ,'ｯ'  ,'ｯ'  ,'ｯ'
             ,'ｷｬ','ｷｨ','ｷｭ','ｷｪ','ｷｮ'
             ,'ｼｬ','ｼｭ','ｼｪ','ｼｮ'
             ,'ｼｬ','ｼ'  ,'ｼｭ','ｼｪ','ｼｮ'
             ,'ﾁｬ','ﾁ'  ,'ﾁｭ','ﾁｪ','ﾁｮ'
             ,'ﾂｧ','ﾂｨ','ﾂ'  ,'ﾂｪ','ﾂｫ'
             ,'ﾃｬ','ﾃｨ','ﾃｭ','ﾃｪ','ﾃｮ'
             ,'ﾁｬ','ﾁｨ','ﾁｭ','ﾁｪ','ﾁｮ'
             ,'ﾆｬ','ﾆｭ','ﾆｮ'
             ,'ﾋｬ','ﾋｭ','ﾋｮ'
             ,'ﾐｬ','ﾐｭ','ﾐｮ'
             ,'ﾘｬ','ﾘｭ','ﾘｮ'
             ,'ｳｧ','ｳｨ','ｳｪ','ｳｫ'
             ,'ゐ'  ,'ゑ'
             ,'ｷﾞｬ','ｷﾞｭ','ｷﾞｮ'
             ,'ｼﾞｬ','ｼﾞｭ','ｼﾞｮ'
             ,'ﾋﾞｬ','ﾋﾞｭ','ﾋﾞｮ'
             ,'ﾋﾟｬ','ﾋﾟｭ','ﾋﾟｮ'
             ,'ﾃﾞｬ','ﾃﾞｨ','ﾃﾞｭ','ﾃﾞｪ','ﾃﾞｮ'
             ,'ﾁﾞｬ','ﾁﾞｨ','ﾁﾞｭ','ﾁﾞｪ','ﾁﾞｮ'
             ,'ｬ','ｬ','ｭ','ｭ','ｮ','ｮ'
             ,'ヮ','ヮ','ヶ','ヶ'
             ,'ｧ','ｨ','ぅ','ｪ','ｫ'
             ,'ｧ','ｨ','ぅ','ｪ','ｫ'
             ,'ｶ','ｷ','ｸ','ｹ','ｺ'
             ,'ｻ','ｼ','ｽ','ｾ','ｿ'
             ,'ﾀ','ﾁ','ﾂ','ﾃ','ﾄ'
             ,'ﾅ','ﾆ','ﾇ','ﾈ','ﾉ'
             ,'ﾊ','ﾋ','ﾌ','へ','ﾎ'
             ,'ﾌｧ','ﾌｨ','ﾌ','ﾌｪ','ﾌｫ'
             ,'ﾏ','ﾐ','ﾑ','ﾒ','ﾓ'
             ,'ﾔ','ﾕ','ﾖ','ゐ','ゑ'
             ,'ﾗ','ﾘ','ﾙ','ﾚ','ﾛ'
             ,'ﾜ','ｳｨ','ｳ','ｳｪ','ｦ'
             ,'ｶﾞ','ｷﾞ','ｸﾞ','ｹﾞ','ｺﾞ'
             ,'ｻﾞ','ｼﾞ','ｽﾞ','ｾﾞ','ｿﾞ'
             ,'ｼﾞｬ','ｼﾞ','ｼﾞｭ','ｼﾞｪ','ｼﾞｮ'
             ,'ﾀﾞ','ﾁﾞ','ﾂﾞ','ﾃﾞ','ﾄﾞ'
             ,'ﾊﾞ','ﾋﾞ','ﾌﾞ','ﾍﾞ','ﾎﾞ'
             ,'ﾊﾞ','ﾋﾞ','ﾌﾞ','ﾍﾞ','ﾎﾞ'
             ,'ﾊﾟ','ﾋﾟ','ﾌﾟ','ﾍﾟ','ﾎﾟ'
             ,'ﾝ','ｱ','ｲ','ｳ','ｴ','ｵ','ｰ');

    return str_replace($s,$r,$i);
}
?>


