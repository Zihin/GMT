<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 从数据读取产品列表
 * @param int $num 读取条数
 * @param int|string cate 类别ID号或ID串
 */
function func_pd_list($num, $cate=null, $recom=null, $not = null){
	include_once LIB_DIR.'/common/category.php';
	$db = Core::getDb();
	$db->debug = true;
	$sqlWhere = " where state=1 and new=0";
	$sqlWhere .= $cate?" and cate in(".implode(Category::getAllChild($cate),',').")" : '';
	$sqlWhere .= $recom?" and recom = 1" : '';
	$sqlWhere .= $not?" and id not in($not)" : '';
	$sqlOrder = " order by id desc";
	$sql = "select id, title, put_time,content,pic from ".TB_PREFIX."article";
	$rs = $db->SelectLimit($sql.$sqlWhere.$sqlOrder,$num,0);
	$list = array();
	while(!$rs->EOF){
		$rs->fields['put_time'] = date('m-d',$rs->fields['put_time']);
		$rs->fields['order_url'] = Core::getUrl('cart','order',array('act'=>'add','id'=>$rs->fields['id']));
		$rs->fields['link'] = Core::getUrl('view', 'product', array('id'=>$rs->fields['id']));
		$list[] = $rs->fields;
		$rs->MoveNext();
	}
	return stripQuotes($list);
}
?>