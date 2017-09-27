<?php
/***************************************************************
 * 显示后台首页
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class Index extends Page{
	var $AuthLevel = ACT_NEED_LOGIN;
	
	function process(){
		$pvar['site_name'] = SITE_NAME;
		$pvar['username'] = $this->sess->get('username');
		$pvar['groupname'] = $this->sess->get('groupname');
		$pvar['groupdes'] = $this->sess->get('description');
		
		$this->addTplFile('index');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
}
?>
