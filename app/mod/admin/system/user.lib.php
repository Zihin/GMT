<?php
/***************************************************************
 * 用户管理公用函数
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
 include_once LIB_DIR.'/common/formelem.php';
 /**
  * 用户组选择器
  * @param string $name 指定选择器的名称
  * @param string $def 默认选中项
  * @return string HTML字串
  */
 function groupSelect($name,$def){
 	$db = Core::getDb();
 	$data = array(''=>'');
 	$sql = "select * from ".TB_PREFIX."sys_group";
 	$rs = $db->Execute($sql);
 	while(!$rs->EOF){
 		$data[$rs->fields['id']] = $rs->fields['title'];
 		$rs->MoveNext();
 	}
 	return Form::select($name,$data,$def);
 }
?>