环境要求
<=php5.2
目录配置，如果在根目录下变量值就留空
define('WEB_DIR', ROOT.'');
define('URL_FIX', '/qpmg');	//URL修正

修改数据库连接配置
app\etc\global.config.php
//使用MySQL数据库
$conf['db']['driver'] = 'mysql';
$conf['db']['host'] = 'localhost';
$conf['db']['user'] = 'root';
$conf['db']['passwd'] = '123456';
$conf['db']['dbname'] = 'qpmg';/**/

清空app\var\category目录下的缓存
清空app\var\session\admin目录下的缓存
清空app\var\session\front目录下的缓存
