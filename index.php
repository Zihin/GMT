<?php
/***************************************************************
 * 前台入口文件
 * 
 * @author yeahoo2000@163.com
 ***************************************************************/
//define('sys_time_start', array_sum(explode(' ', microtime())));

include_once 'app/etc/front.config.php';
include_once LIB_DIR.'/errorhandler.php';
include_once LIB_DIR.'/core.php';
include_once LIB_DIR.'/global.php';

ob_start();	//压缩输出
Core::run();
//echo "<div align='center'>执行用时:".round((array_sum(explode(' ', microtime())) - sys_time_start) * 1000, 2)." ms</div>";
ob_end_flush();
?>