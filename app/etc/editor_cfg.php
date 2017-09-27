<?php
include_once('../../app/etc/admincp.config.php');

session_save_path(VAR_DIR.'/session/'.DIR_PREFIX);
session_cache_limiter('private, must-revalidate');
session_start();
if( (time() - $_SESSION['user']['last_action_time']) > IDLE_TIMEOUT){
	die('登录超时了,请重新登录后再进行操作...');
}
//编辑上传文件设置
define('IMAGE_FILE_DIR',WEB_DIR.'/'.UPLOAD_DIR.'imgs/');	//用户保存图片的磁盘路径,必须有可写权限
define('IMAGE_WEB_DIR', UPLOAD_DIR.'imgs/');			//用户保存图片的URL地址(相对于SITE_URL)
//define('IMAGE_WEB_DIR', URL_FIX.'/uls/imgs/');	//用户保存图片的URL地址
define('DOCUMENT_FILE_DIR',WEB_DIR.'/'.UPLOAD_DIR.'docs/');	//用户保存文档的磁盘路径,必须有可写权限
define('DOCUMENT_WEB_DIR', UPLOAD_DIR.'docs/');	//用户保存文档的URL地址(相对于SITE_URL.URL_FIX)

//echo 'ifd:'.IMAGE_FILE_DIR.'<br> iwd:'.IMAGE_WEB_DIR."<br>dfd: "
	//.DOCUMENT_FILE_DIR."<br> dwd: ".DOCUMENT_WEB_DIR;
define('WP_WEB_DIRECTORY', SITE_URL.'/scripts/editor/');
define('IMAGE_FILE_DIRECTORY',IMAGE_FILE_DIR);
define('IMAGE_WEB_DIRECTORY', IMAGE_WEB_DIR);
define('DOCUMENT_FILE_DIRECTORY', DOCUMENT_FILE_DIR);
define('DOCUMENT_WEB_DIRECTORY', DOCUMENT_WEB_DIR);

$trusted_directories = array(
// Follow this format:
// 'unique id' => array('file dir', 'web dir'),
// Examples:
// 'foo.com_images' => array('c:/html/users/foo.com/html/imgs/', 'http://www.foo.com/imgs/'), 
// 'bar.com_images' => array($_SERVER['DOCUMENT_ROOT'].'/bar/', '/bar/'),
);
define('SMILEY_FILE_DIRECTORY', null);
define('SMILEY_WEB_DIRECTORY', null);
define('DEFAULT_LANG', 'zh-gb.php');                
define('DOMAIN_ADDRESS', strtolower(substr($_SERVER['SERVER_PROTOCOL'],0,strpos($_SERVER['SERVER_PROTOCOL'],'/')) . (isset($_SERVER['HTTPS']) ? ($_SERVER['HTTPS'] == "on" ? 's://' : '://') : '://' ) . $_SERVER['SERVER_NAME'] ) );


// -----------------------------------------------------
// File types

// What types of images can be uploaded? Separate with a comma.
$image_types = '.jpg, .jpeg, .gif, .png, .swf';

// What types of documents can be uploaded? Separate with a comma.
$document_types = '.html, .htm, .pdf, .doc, .rtf, .txt, .xl, .xls, .ppt, .pps, .zip, .tar, .swf, .wmv, .rm, .mov, .jpg, .jpeg, .gif, .png';

// -----------------------------------------------------
// File sizes

$max_image_width = 1024;                         // maximum allowed width of uploaded images in pixels
$max_image_height = 1024;                        // maximum allowed height of uploaded images in pixels
$max_file_size = 500000;                         // maximum allowed filesize for uploaded images upload in bytes
$max_documentfile_size = 50000000;               // maximum allowed filesize for uploaded documents in bytes

// -----------------------------------------------------
// File edting permissions
// Important Note: for security reasons these features are set to false by default 

//if(1 == $_SESSION['user']['role']){
	$delete_files = 1;                          // can users delete files? (be very careful with this one)
	$delete_directories = 1;                    // can users delete directories? (be even more careful with this one)
	$create_directories = 1;                    // can users create directories?
	$rename_files = 1;                          // can users re-name files?
	$rename_directories = 1;                    // can users rename directories?
	$upload_files = 1;                          // can users upload files??
	$overwrite = 1;                             // If users can upload and they upload a file with the same name as an existing file are they allowed to overwrite the existing file?
/*
}
else{
	$delete_files = 0;                          // can users delete files? (be very careful with this one)
	$delete_directories = 0;                    // can users delete directories? (be even more careful with this one)
	$create_directories = 1;                    // can users create directories?
	$rename_files = 0;                          // can users re-name files?
	$rename_directories = 0;                    // can users rename directories?
	$upload_files = 1;                          // can users upload files??
	$overwrite = 0;                             // If users can upload and they upload a file with the same name as an existing file are they allowed to overwrite the existing file?
}
*/
?>
