<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 检测是身份证/护照号码格式是否正确
 * @param string $email Email字串
 * @return bool
 */
function func_is_passport_no($passport_no){
    //身份证
	if (preg_match('/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/', $passport_no))
		return true;
        //护照
	if (preg_match('/^[a-zA-Z]{5,17}$/', $passport_no))
		return true;
	if (preg_match('/^[a-zA-Z0-9]{5,17}$/', $passport_no))
		return true;
        
	return false;
}
?>