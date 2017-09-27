<?php
/***************************************************************
 * 公共库函数
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/formelem.php';

function colorSel($name, $def=null){
	$db = Core::getDb();
	$sql = "select * from ".TB_PREFIX."def_color";
	$rs = $db->Execute($sql);
	$data = array(''=>'');
	while(!$rs->EOF){
		$data[$rs->fields['color']] = $rs->fields['color'];
		$rs->MoveNext();
	}
	return Form::select($name,$data,$def);
}

function sizeSel($name, $def=null){
	$db = Core::getDb();
	$sql = "select * from ".TB_PREFIX."def_size";
	$rs = $db->Execute($sql);
	$data = array(''=>'');
	while(!$rs->EOF){
		$data[$rs->fields['size']] = $rs->fields['size'];
		$rs->MoveNext();
	}
	return Form::select($name,$data,$def);
}
function whouseSel($name, $def=null, $disable = false){
	$db = Core::getDb();
	$sql = "select * from ".TB_PREFIX."warehouse";
	$rs = $db->Execute($sql);
	$data = array(''=>'');
	while(!$rs->EOF){
		$data[$rs->fields['id']] = $rs->fields['name'];
		$rs->MoveNext();
	}
	return Form::select($name,$data,$def,$disable);
}
?>