<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/program/php/option.php');

	// -------  オプション  -------
	if($_POST['idname'] == "option"){
		$sql = "update plv_option set keywords='".form($_POST['keywords'])."', description='".form($_POST['description'])."', mail='".form($_POST['mail'])."', major='".form($_POST['major'])."' where ID='1'";
		$re = $db->run($sql);
		$data['completion'] = 1;
	}

	// -------  記事の追加  -------
	if($_POST['idname'] == "article"){
		$sql = "select * from posts where relation='".$_POST['relation']."' order by sort DESC";
		$re = $db->run($sql);
		$sort = $re[0]['sort']+1;
		$sql = "insert into posts(inner_title, content1, content2, content3, content4, content5, relation, sort) 
						    value('".$_POST['new_title']."', '".$_POST['content1']."', '".$_POST['content2']."',
							'".$_POST['content3']."', '".$_POST['content4']."', '".$_POST['content5']."', '".$_POST['relation']."', '".$sort."')";
		$re = $db->run($sql);
		//$data['test'] .= $sql;
		$data['completion'] = 1;
		$data['new'] = 1;
	}

	if($_POST['idname'] == "midashi_add"){
		$sql = "insert into posts(relation, sort) value('".$_POST['relation']."', '".$_POST['new_sort']."')";
		$re = $db->run($sql);
		$sql = "select * from posts where relation='".$_POST['relation']."' order by sort DESC";
		$re = $db->run($sql);
		$data['id'] = $re[0]['ID'];
		//$data['test'] .= $sql;
	}

	if($_POST['idname'] == "midashi_del"){
		$sql = "delete from posts where ID='".$_POST['del_ID']."'";
		$re = $db->run($sql);
		//$data['test'] .= $sql;
	}

	// -------  他ページ  -------
	else{
		//$last = end($_POST['sort']);
		// -------  FAQ  -------
		if($_POST['idname'] == 'faq'){
			for($i = 0; $i < count($_POST['FAQ']); $i++){
				$id = $_POST['FAQ']['ID_'.$i]['id'];
				$sort = $_POST['FAQ']['ID_'.$i]['sort'];
				$title = $_POST['FAQ']['ID_'.$i]['title'];
				$q = $_POST['FAQ']['ID_'.$i]['q'];
				$a = $_POST['FAQ']['ID_'.$i]['a'];
				$sql2 = "update faq set question='".$q."', answer='".$a."', flag='".$sort."', flag_name='".$title."' where ID='".$id."'";
				$re2 = $db->run($sql2);
				$data['test']  .= $sql2."<br />";
			}
		}
		//$data['test'] = count($_POST['FAQ']);
		
		for($i = 0; $i < count($_POST['contents']); $i++){
			$sort = $_POST['contents']['ID_'.$i]['sort'];//ソートの数
			$count = count($_POST['contents']['ID_'.$i]['inner_contents'][$sort]);//中のコンテンツの数
			$inner_contents = '';
			if($count == 0){
				for($v = 0; $v < 10; $v++){
					$inner_contents .= " content".($v+1)."='',";
				}
			}else{
				for($v = 0; $v < $count; $v++){
					$inner_contents .= " content".($v+1)."='".$_POST['contents']['ID_'.$i]['inner_contents'][$sort][$v]."',";
				}
			}
			
			$sql = "update posts set page_title='".form($_POST['contents']['ID_'.$i]['page_title'])."', 
									 keywords='".form($_POST['contents']['ID_'.$i]['keywords'])."', 
									 description='".form($_POST['contents']['ID_'.$i]['description'])."', 
									 contents_title='".$_POST['contents']['ID_'.$i]['contents_title']."', 
									 inner_title='".$_POST['contents']['ID_'.$i]['inner_title']."', 
									".$inner_contents." 
									 sort='".$sort."' 
									 where ID='".$_POST['contents']['ID_'.$i]['id']."'";
			$result = $db->run($sql);
			//$data['test'] .= $sql.'<br />';
			//$inner_contents = '';
		}

		$data['completion'] = 1;
	}

	// -------  JSON 出力  -------
	echo json_encode($data);
?>