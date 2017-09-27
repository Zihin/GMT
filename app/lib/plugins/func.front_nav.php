<?php

/* * *************************************************************
 * 插件式函数定义文件
 * 
 * @author alen1984116@126.com
 * ************************************************************* */

/**
 * 引用导航模板
 */
function func_front_nav() {
    include_once LIB_DIR . '/common/category.php';
    $child = Category::getChild(CATE_INFO);
    $link = 'index.php?project,showlist';
    foreach ($child as $v) {
        $data = Category :: getData($v);
        $a = CORE_SEF_QUERY_STRING ? "<a href=\"$link,cate,{$data['id']}\" target=\"$target\">" : "<a href=\"$link&cate={$data['id']}\" target=\"$target\">";
        $outStr .= $data['child_num'] ? "<li>$a{$data['title_' . LANGUAGE]}</a>\n" . Category :: getList($data['id'], $link, $target, $lev + 1) . "</li>\n" : "<li>$a{$data['title_' . LANGUAGE]} {$data['title_en']}</a></li>\n";
    }
    include TPL_DIR . '/front/nav.' . LANGUAGE . '.tpl';
}

?>
