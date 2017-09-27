<?php
/**
 * 用utf8_encode处理变量,可处理多维数组
 */
function utf8Encode($vars) {
	if (is_array($vars) && !count($vars))
		return array ();
	if (is_array($vars)) {
		foreach ($vars as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k1 => $v1) {
					$vars[$k][$k1]= utf8Encode($v1);
				}
			} else
				$vars[$k]= utf8_encode($v);
		}
	} else
		$vars= utf8_encode($vars);
	return $vars;
}
/**
 * 用utf8_decode处理变量,可处理多维数组
 */
function utf8Decode($vars) {
	if (is_array($vars) && !count($vars))
		return array ();
	if (is_array($vars)) {
		foreach ($vars as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k1 => $v1) {
					$vars[$k][$k1]= utf8Decode($v1);
				}
			} else
				$vars[$k]= utf8_decode($v);
		}
	} else
		$vars= utf8_decode($vars);
	return $vars;
}

/**
 * 用addslashes处理变量,可处理多维数组
 */
function addQuotes($vars) {
	if (is_array($vars) && !count($vars))
		return array ();
	if (is_array($vars)) {
		foreach ($vars as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k1 => $v1) {
					$vars[$k][$k1]= addQuotes($v1);
				}
			} else
				$vars[$k]= addslashes($v);
		}
	} else
		$vars= addslashes($vars);
	return $vars;
}

/**
 * 对指定变量进行stripslashes处理,可处理多维数组
 */
function stripQuotes($vars) {
	if (is_array($vars) && !count($vars))
		return array ();
	if (is_array($vars)) {
		foreach ($vars as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k1 => $v1) {
					$vars[$k][$k1]= stripQuotes($v1);
				}
			} else
				$vars[$k]= stripslashes($v);
		}
	} else
		$vars= stripslashes($vars);
	return $vars;
}

/**
 * 用trim处理变量,可处理多维数组
 */
function trimArr($vars) {
	if (is_array($vars) && !count($vars))
		return array ();
	if (is_array($vars)) {
		foreach ($vars as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k1 => $v1) {
					$vars[$k][$k1]= trimArr($v1);
				}
			} else
				$vars[$k]= trim($v);
		}
	} else
		$vars= trim($vars);
	return $vars;
}

/**
 * 用HTML修饰出错信息
 * @param string $msg 错误信息字符串
 * @return string
 */
function renderMsg($msg) {
	if (is_array($msg) && !count($msg))
		return array ();
	if (is_array($msg)) {
		foreach ($msg as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k1 => $v1) {
					$msg[$k][$k1]= renderMsg($v1);
				}
			} else
				$msg[$k]= '<div style="color:#f00;font-size:12px;"><img src="imgs/icon/err.gif" align="absmiddle">&nbsp;'.$v.'</div>';
		}
	} else
		$msg= '<div style="color:#f00;font-size:12px;"><img src="imgs/icon/err.gif" align="absmiddle">&nbsp;'.$msg.'</div>';

	return $msg;
}

function textFormat($text) {
	if (is_array($text) && !count($text))
		return array ();
	if (is_array($text)) {
		foreach ($text as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k1 => $v1) {
					$text[$k][$k1]= textFormat($v1);
				}
			} else
				$text[$k]= nl2br(htmlspecialchars($v));
		}
	} else
		$text= nl2br(htmlspecialchars($text));
	return $text;
}

/**
 * 显示指定变量的内容 
 * @param mixd $var 变量名
 */
function vardump($var, $name = null) {
	echo "---------$name---------<pre>";
	print_r($var);
	echo '</pre>------------------------';
}

/**
 * 创建目录,可以创建父目录
 * (****注意:如果目录路径指向了某个文件,则会将这个文件删除****)
 * @param string $path 目录路径
 * @param int $mode 目录的读写属性
 */
function makedir($path, $mode= 0777) {
	$path = dirname($path);
	if(file_exists($path)) return true;
	if(!preg_match('!^'.addslashes(ROOT).'/!', $path)){
		mylog(L_WARNING, __FUNCTION__.'():禁止操作的路径'.$path);
		return false;
	}
	$path= preg_replace('!^'.addslashes(ROOT).'/!', '', $path);
	$dirstack= explode('/', $path);
	if (count($dirstack) > 50){
		mylog(L_WARNING, __FUNCTION__.'():目录级数超过50,不允许创建');
		return false;
	}
	$path= ROOT.'/';
	while ($newdir= array_shift($dirstack)) {
		if(is_file($path.$newdir)){	//如果这个路径指向的是文件,则删除
			@unlink($path.$newdir);
		}
		$path .= $newdir.'/';
		$stat= @mkdir($path, $mode);
	}
	return $stat;
}

/**
 * 写磁盘文件,会自动创建文件名中带的目录路径
 */
function wfile($file, $text, $mode= 'w') {
	$oldmask= umask(0);
	$fp= @fopen($file, $mode);
	if (!$fp) {
		if (!makedir($file) || !($fp= fopen($file, $mode))){
			mylog(L_ERROR, __FUNCTION__.'():写文件操作失败');
			return false;
		}
	}
	fwrite($fp, $text);
	fclose($fp);
	umask($oldmask);
	return true;
}

/**
 * 递归删除指定目录下的所有文件和目录(也可作用于文件)
 * @param string $dirName 目录路径或文件路径
 */
function removeFile($dirName) {
	$path = dirname($dirName);
	if(!preg_match('!^'.addslashes(ROOT).'/!', $path)){
		mylog(L_WARNING, __FUNCTION__.'():禁止操作的路径'.$path);
		return false;
	}
	if(is_file($dirName)){
		$result = unlink($dirName)? true : false;
	}
	if (is_dir($dirName)) {
		$handle= opendir($dirName);
		while (($file= readdir($handle)) !== false) {
			if ($file != '.' && $file != '..') {
				$dir= $dirName.DIRECTORY_SEPARATOR.$file;
				is_dir($dir) ? removeFile($dir) : unlink($dir);
			}
		}
		closedir($handle);
		$result= rmdir($dirName) ? true : false;		
	}
	return $result;
}

/**
 *	得到客户端IP地址 
 */
function clientIp() {
	if (getenv('HTTP_CLIENT_IP')) {
		$ip= getenv('HTTP_CLIENT_IP');
	}
	elseif (getenv('HTTP_X_FORWARDED_FOR')) {
		list ($ip)= explode(',', getenv('HTTP_X_FORWARDED_FOR'));
	}
	elseif (getenv('REMOTE_ADDR')) {
		$ip= getenv('REMOTE_ADDR');
	} else {
		$ip= $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

/**
 * 取得已上传图片的索引图路径,如果不存在则自动生成
 * (只对上传目录中的图片进行处理)
 * @param string $oImage 原始图片路径(只接收UPLOAD_DIR目录下的路径)
 * @param int maxWidth 生成索引图的最大宽度
 * @param int maxHeight 生成索引图的最大高度
 * @param int quality 生成索引图的质量(0-100)
 * @return string 索引图片的路径
 */
function getSmallImg($oImage, $maxWidth= 150, $maxHeight= 150, $quality= 75) {
	if (!GD_ENABLE || !preg_match("!^".UPLOAD_DIR."!", $oImage)) {
		return $oImage;
	}

	$image= preg_replace("!^".UPLOAD_DIR."!", '', $oImage);
	$image= UPLOAD_DIR."s/".$image;
	$fullpath= WEB_DIR.'/'.$image;

	if (file_exists($fullpath)) {
		return $image;
	}
	if(!file_exists($oImage)){		//如果原始图片文件已丢失
		return $oImage;				//则不作处理直接返回
	}
	list ($width, $height, $type)= getimagesize($oImage);

	$xRatio= $maxWidth / $width;
	$yRatio= $maxHeight / $height;

	if (($width <= $maxWidth) && ($height <= $maxHeight)) {
		$tnWidth= $width;
		$tnHeight= $height;
	}
	elseif (($xRatio * $height) < $maxHeight) {
		$tnHeight= ceil($xRatio * $height);
		$tnWidth= $maxWidth;
	} else {
		$tnWidth= ceil($yRatio * $width);
		$tnHeight= $maxHeight;
	}
	if (IMAGETYPE_JPEG == $type)
		$src= imagecreatefromjpeg($oImage);
	if (IMAGETYPE_GIF == $type) {
		if (!function_exists('imagecreatefromgif')){
			mylog(L_ERROR, __FUNCTION__.'():'.'系统不支持处理GIF图片');
			return $oImage;
		}else
			$src= imagecreatefromgif($oImage);
	}
	if (IMAGETYPE_PNG == $type)
		$src= imagecreatefrompng($oImage);

	$dst= imagecreatetruecolor($tnWidth, $tnHeight);
	imagecopyresampled($dst, $src, 0, 0, 0, 0, $tnWidth, $tnHeight, $width, $height);
	if (!@ imagejpeg($dst, $fullpath, $quality)) {
		if (!makedir($fullpath))
			return $oImage;
		else if (!@ imagejpeg($dst, $fullpath, $quality)) {
			mylog(L_ERROR, __FUNCTION__.'():'.'创建索引图片失败:');
		}
	};
	@ imagedestroy($src);
	@ imagedestroy($dst);
	return $image;
}

/**
 * 调用插件式函数
 * 插件式函数定义在ROOT/lib/plugins中
 * @param string $name 函数名
 */
function plugin($name) {
	include_once LIB_DIR.'/plugins/func.'.$name.'.php';
	$args= func_get_args();
	unset ($args[0]);
	return call_user_func_array('func_'.$name, $args);
}

function snFormat($sn){
	return str_replace(' ','0',sprintf('%8d',$sn));
}

function mylog($level, $msg){
	$msg = "[$level] [".date('Y-m-d H:i:s')."] [".DIR_PREFIX."_".CURRENT_MODULE."_".CURRENT_ACTION."] $msg\r\n\r\n";
	error_log($msg, 3, VAR_DIR.'/logs/core.log');
}
function utf8Cut($str,$length=50,$doc='...'){
		if(mb_strlen($str,"utf8") > $length){
			return mb_substr($str,0,$length,"utf8");
		}else {
			return $str;
		}
}
?>
