<?php
/***************************************************************
 * 退出登录
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class Logoff extends Action{
	var $AuthLevel = ACT_OPEN;
	function process(){
		$this->sess->end();
		Core::redirect(Core::getUrl('index'));
	}
}
?>