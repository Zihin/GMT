<?php
/***************************************************************
 * 阅读文章
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/pager.php';
include_once LIB_DIR.'/common/category.php';
class About extends Page{
	var $AuthLevel = ACT_OPEN;
	var $db;
	var $tab = 'article';
	var $row = 12;		//每页显示的文章条数
	var $pathAppend = 'id';
	var $useContentPart = true;
	var $cacheTime = 0;	//设置缓存时间,单位:�?.-1为永�?,0为不使用
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		$this->cPage = $this->input['page'];
		
		$this->db = Core::getDb();
	}
	function process(){
		        //获取配置信息
		$pvar = array();
		$pvar['cf'] = plugin('getconfig');
                
		$pvar['self_id'] = 'about';
		$pvar['nav_id'] = 'gmt';
		$this->addTplFile('about');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
}
?>