<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 读取指定类别的子类别
 * @param int $cateId 类别ID号
 */
function func_cate_list($id, $link, $target='_self', $lev= 1) {
	include_once LIB_DIR.'/common/category.php';
	return Category::getList($id, $link, $target, $lev);
}
?>