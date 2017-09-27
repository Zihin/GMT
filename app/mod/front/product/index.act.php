<?php
/***************************************************************
 * 显示首页
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class Index extends Page {
	var $AuthLevel= ACT_OPEN;
	var $db;
	function __construct() {
		parent :: __construct();
		require_once LIB_DIR.'/common/category.php';
		$this->db= Core :: getDb();
		//$this->db->debug= true;
	}
	function process() {
		$this->addTplFile('index');
		$this->display();
	}

}
?>
