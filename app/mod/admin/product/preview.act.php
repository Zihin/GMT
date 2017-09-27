<?php
/***************************************************************
 * 预览
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

class Preview extends Page{
	var $db;
	var $tab = 'product';

	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
	}
	
	function process(){
		include_once LIB_DIR."/common/category.php";

		$id = $this->input['id'];

		if(!is_numeric($id)){
			Core::raiseMsg('参数错误,没有指定有效的ID号');
		}
		$sql = "select * from $this->tab where id=$id";
		$data = $this->db->GetRow($sql);
		if(!count($data)){
			Core::raiseMsg('页面不存在或者已被删除...');
		}
		$cate = Category::getData($data['cate']);
		$data['put_time'] = date('Y-m-d',$data['put_time']);
		$data['cate'] = $cate['title'];
		$data['pic_s'] = getSmallImg($data['pic']);
		
		$this->addTplFile($cate['tpl_v'],true);
		$this->assign(stripQuotes($data));
		$this->display();
	}
}
?>