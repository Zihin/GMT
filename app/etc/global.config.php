<?php
/***************************************************************
 * 系统全局配置文件
 ***************************************************************/
define('ROOT', 			realpath(dirname(__FILE__).'/../..'));
define('ETC_DIR',		ROOT.'/app/etc');
define('LIB_DIR',		ROOT.'/app/lib');
define('MOD_DIR',		ROOT.'/app/mod');
define('VAR_DIR',		ROOT.'/app/var');
define('WEB_DIR',		ROOT.'');
define('TPL_DIR',		ROOT.'/app/tpl');
define('DB_DIR',		ROOT.'/app/db');	//for access database
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
define('CORE_SEF_QUERY_STRING', 	true);	//搜索引擎友好
define('GD_ENABLE', true);	//允许使用GD库

define('SITE_NAME',		'网站开发框架');
define('PROTOCOL',		'http');
define('URL_FIX',		'');	//URL修正
define('SITE_URL', 		PROTOCOL.'://'.$_SERVER['HTTP_HOST'].URL_FIX);
define('UPLOAD_DIR',	'uploads/');		//上传文件的存放目录(相对于SITE_URL.URL_FIX目录)

//邮件发送服务器
$conf['smtp']['host'] = 'smtp.163.com';
$conf['smtp']['from'] = 'gmt_web@163.com';
$conf['smtp']['auth'] = true;
$conf['smtp']['fromname'] = '邮件发送服务器';
$conf['smtp']['username'] = 'gmt_web@163.com';
$conf['smtp']['password'] = 'abcd1234';

//数据库设置=============================================
define('TB_PREFIX','fw_');	//表名前缀
//使用MySQL数据库

$conf['db']['driver'] = 'mysql';
$conf['db']['host'] = 'localhost';
$conf['db']['user'] = 'root';
//$conf['db']['passwd'] = 'abcD!@#$';
$conf['db']['passwd'] = 'root';
$conf['db']['dbname'] = 'gmt';/**/

/*
//使用ACCESS数据库
$conf['db']['driver'] = 'ado_access';
$conf['db']['host'] = 'PROVIDER=Microsoft.Jet.OLEDB.4.0;DATA SOURCE='. DB_DIR.'/database.mdb' . ';USER ID=;PASSWORD=;';;
$conf['db']['user'] = '';
$conf['db']['passwd'] = '';
$conf['db']['dbname'] = '';/**/
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

define('CATE_INFO', 2);
define('CATE_PD', 3);

//语言设定
$GLOBALS['multi_language'] = array('zh', 'en');
define('LANGUAGE_DEFAULT', 'zh');

$GLOBALS['order_state'] = array(''=>'','-1'=>'已撤消',0=>'未处理',1=>'已完成');
$GLOBALS['test_center'] = array('1'=>'广州考试中心');//考试中心
?>
