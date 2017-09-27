<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 从数据读取资讯列表
 * @param int $num 读取条数
 * @param int|string cate 类别ID号或ID串
 */
function func_LBpic($pic){
	include_once LIB_DIR.'/common/category.php';
	$db = Core::getDb();
	//$db->debug = true;
	$data = array();
	$data['cate'] = $cate?Category::getTitle($cate):'';
	$data['more_link'] = Core::getUrl('showlist','article',array('cate'=>$cate));
	$sqlWhere = " where state=1";
	$sqlWhere .= $cate?" and cate in(".implode(Category::getAllChild($cate),',').")" : '';
	$sqlWhere .= $not?" and id not in($not)" : '';
	$sqlOrder = " order by id desc";
	$sql = "select id, title, put_time,content from ".TB_PREFIX."article";
	$rs = $db->SelectLimit($sql.$sqlWhere.$sqlOrder,$num,0);
	$list = array();
	while(!$rs->EOF){
		$rs->fields['put_time'] = date('Y-m-d',$rs->fields['put_time']);
		$rs->fields['link'] = Core::getUrl('view', 'article', array('id'=>$rs->fields['id']));
                $rs->fields['intro_content'] = substr(strip_tags($rs->fields['content']),0,200);
		$data['list'][] = $rs->fields;
		$rs->MoveNext();
	}
	return stripQuotes($data);
}
?>
