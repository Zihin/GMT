<?php
/***************************************************************
 * 阅读文章
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class Contacts extends Page{
	var $AuthLevel = ACT_OPEN;
	var $db;
	var $tab = 'config';
	var $pathAppend = 'id';
	var $useContentPart = true;
	var $cacheTime = 0;	//设置缓存时间,单位:�?.-1为永�?,0为不使用
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
	}
	function process(){
            //获取配置信息
		$data = plugin('getconfig');

            
                $data['self_id'] = 'contacts';
		$this->addTplFile('contacts');
		$this->assign(stripQuotes($data));
		$this->display();
	}
}
?>