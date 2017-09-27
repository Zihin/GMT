<?php
/**
 * 配置文件
 */
error_reporting(E_ALL ^E_NOTICE);
define('DEBUG', 1);

include_once 'global.config.php';

define('MODULE_DEFAULT','default');	//默认模块
define('ACTION_DEFAULT','index');	//默认动作
define('DIR_PREFIX', 	'admin');	//目录标识

define('IDLE_TIMEOUT',	3600);		//无操作超时设定,单位:秒
define('DATE_FORMAT', 'Y/m/d');
define('DATE_FORMAT_L', 'Y/m/d H:i');

define('TB_PERMS',		TB_PREFIX."sys_permissions");
define('TB_GROUP_PRIV',	TB_PREFIX."sys_group_priv");
?>
