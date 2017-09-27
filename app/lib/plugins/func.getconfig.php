<?php

/* * *************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 * ************************************************************* */

/**
 * 从数据读取网站配置
 * @param int $num 读取条数
 * @param int|string $assoc_id 关联ID
 */
function func_getconfig() {
    $tab = TB_PREFIX.'config';
    $db = Core::getDb();
    //$db->debug = true;
    $data = array();
    $sql = "select * from $tab where id=1";
    $data = $db->GetRow($sql);
    $data['put_time'] = date('Y-m-d',$data['put_time']);
    return stripQuotes($data);
}

?>
