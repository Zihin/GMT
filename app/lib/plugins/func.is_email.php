<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 检测是email格式是否正确
 * @param string $email Email字串
 * @return bool
 */
function func_is_email($email){
	if (preg_match('/^[a-z0-9_\-\.]+@[a-zZ0-9_-]+\.[a-z0-9_-]+[a-z\.]+/', $email))
		return true;
	return false;
}
?>