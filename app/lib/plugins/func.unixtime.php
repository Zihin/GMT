<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 将YYYY-MM-DD格式的日期转换成unixtime格式
 * @param string $date 待转换字串(必须符合YYYY-MM-DD格式)
 * @param string $time 时间字串(必须符合"时:分:秒"格式
 * @return int unixtime格式的值
 */
function func_unixtime($date, $time= null) {
	$date= explode('-', $date);
	if ($time) {
		list ($h, $i, $s)= explode(':', $time);
		return mktime($h, $i, $s, $date[1], $date[2], $date[0]);
	}
	return mktime(0, 0, 0, $date[1], $date[2], $date[0]);
}
?>