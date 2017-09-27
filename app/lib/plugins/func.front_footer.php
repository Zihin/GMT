<?php

/* * *************************************************************
 * 插件式函数定义文件
 * 
 * @author alen1984116@126.com
 * ************************************************************* */

/**
 * 引用底部模板
 */
function func_front_footer() {
    $db = Core::getDb();
    //$db->debug = true;
    $num = 12;
    $sqlWhere = " where state=1";
    $sqlOrder = " order by id desc";
    $sql = "select * from " . TB_PREFIX . "link";
    $rs = $db->SelectLimit($sql . $sqlWhere . $sqlOrder, $num, 0);
    $list = array();
    while (!$rs->EOF) {
        $list[] = $rs->fields;
        $rs->MoveNext();
    }
    include TPL_DIR . '/front/footer.' . LANGUAGE . '.tpl';
}

?>
