<?php
/***************************************************************
 * 错误处理文件
 * 
 * @author yeahoo2000@163.com
 ***************************************************************/

set_error_handler('errorHandler');

function errorHandler($errno, $errstr, $errfile, $errline) {
	$errRpt= error_reporting();
	if (($errno & $errRpt) != $errno)
		return;
	$msg= "[$errno] \"$errstr\" in file $errfile ($errline).";
	mylog(L_ERROR, $msg);
	debugTrace($msg);
}
function debugTrace($msg) {
	echo '<div style="font-size:14px">';
	echo '<strong>出错信息</strong>';
	echo '<p>'.$msg.'</p>';
	if (!function_exists('debug_backtrace'))
		return;
	echo '<strong>函数调用过程</strong>';
	echo '<pre>';
	$index= -1;
	$backtrace = debug_backtrace();
	$row = count($backtrace);
	foreach ($backtrace as $t) {
		$index ++;
		if ($index == 0) // hide the backtrace of this function
			continue;
		echo '#'.$index.str_repeat('  ',$row-$index);
		if (isset ($t['file']))
			echo basename($t['file']).':'.$t['line'];
		else
			echo '<PHP inner-code>';
		echo ' -- ';
		if (isset ($t['class']))
			echo $t['class'].$t['type'];
		echo $t['function'];
		if (isset ($t['args']) && sizeof($t['args']) > 0)
			echo '(...)';
		else
			echo '()';
		echo "\n";
	}
	echo '</pre>';
	exit (1);
}
?>