<?php
/***************************************************************
 * 生成图片动态码,用于增强登录安全
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/validatecode.php';
class DyncodeImg extends Action{
	var $AuthLevel = ACT_OPEN;
	
	function process(){
		$dynCode = plugin('rand_string',4);
		$this->sess->set('dyncode',$dynCode);//验证码保存到SESSION中
		$_vc = new ValidateCode();  //实例化一个对象
		$_vc->createCode($dynCode);
		$_vc->doimg();
	}
}
?>