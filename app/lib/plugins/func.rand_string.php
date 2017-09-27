<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 随机字串
 * @param int $len 指定随机字串的长度
 * @param string $scope 随机字符的取值范围
 */
function func_rand_string($len, $scope= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890") {
	srand((double) microtime() * 1000000);
	$str_len= strlen($scope) - 1;
	$string= '';
	for ($i= 0; $i < $len; $i ++) {
		$string .= substr($scope, rand(0, $str_len), 1);
	}
	return $string;
}
?>