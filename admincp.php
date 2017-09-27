<?php
/***************************************************************
 * 网站管理系统入口文件
 * 
 * @author yeahoo2000@163.com
 ***************************************************************/
//define('sys_time_start', array_sum(explode(' ', microtime())));

include_once 'app/etc/admincp.config.php';
include_once LIB_DIR.'/errorhandler.php';
include_once LIB_DIR.'/core.php';
include_once LIB_DIR.'/global.php';

ob_start();	//压缩输出
Core::run();
//echo "<div align='center'>执行用时:".round((array_sum(explode(' ', microtime())) - sys_time_start) * 1000, 2)." ms</div><!-- -->";
ob_end_flush();
?>
