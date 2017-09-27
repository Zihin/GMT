<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 从数据读取图片列表
 * @param int $num 读取条数
 * @param int|string $assoc_id 关联ID
 */
function func_pic_list($num, $assoc_id=null){
	$db = Core::getDb();
	//$db->debug = true;
	$data = array();
	$sqlWhere = " where 1";
	$sqlWhere .= $assoc_id?" and assoc_id = '".$assoc_id."'" : '';
	$sqlOrder = " order by id desc";
	$sql = "select * from ".TB_PREFIX."images";
	$rs = $db->SelectLimit($sql.$sqlWhere.$sqlOrder,$num,0);
	$list = array();
	while(!$rs->EOF){
		$data['list'][] = $rs->fields;
		$rs->MoveNext();
	}
	return stripQuotes($data);
}
?>
