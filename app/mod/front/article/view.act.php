<?php
/***************************************************************
 * 阅读文章
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class View extends Page{
	var $AuthLevel = ACT_OPEN;
	var $db;
	var $tab = 'article';
	var $pathAppend = 'id';
	var $useContentPart = true;
	var $cacheTime = 0;	//设置缓存时间,单位:�?.-1为永�?,0为不使用
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
	}
	function process(){
		include_once LIB_DIR."/common/category.php";
		include_once LIB_DIR."/common/contentpart.php";
		$id = $this->input['id'];
		$part = $this->input['part'];
		if(!is_numeric($id)){
			Core::raiseMsg('参数错误,没有指定有效的ID?');
		}
		$sql = "select * from $this->tab where state=1 and id=$id";
		$data = $this->db->GetRow($sql);
		if(!count($data)){
			Core::raiseMsg('页面不存在或者已被删?...');
		}
		$data['put_time'] = date(DATE_FORMAT,$data['put_time']);

		$cate = Category::getData($data['cate']);
		$data['cate_name'] = $cate['title_zh'];
		$data['content'] = contentPart($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'],$data['content'],$part);
		$data['self_id'] = 'article_'.$data['cate'];
		if($data['cate'] == 4) {
			$data['nav_id'] = 'gmt';
		}elseif($data['cate'] == 7){
			$data['nav_id'] = 'member';
		}elseif($data['cate'] == 5){
			$data['nav_id'] = 'news';
		}
		$this->addTplFile('view');
		$this->assign(stripQuotes($data));
		$this->display();
	}
}
?>