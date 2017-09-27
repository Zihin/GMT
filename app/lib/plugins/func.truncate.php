<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 中英文字符串剪切函数
 * @param string $str 待剪切的字串
 * @param int $len 剪切长度
 * @param string $endStr 结尾字符串
 * @return string 
 */
function func_truncate($str, $len, $endStr= null) {
	if (strlen($str) < $len) {
		return $str;
	}
	$len -= strlen($endStr);
	for ($i= 0; $i < $len; $i ++) {
		if (ord($str[$i]) > 127) {
			$output .= $str[$i].$str[$i +1];
			$i ++;
		} else {
			$output .= $str[$i];
		}
	}
	return $output.$endStr;
}
?>