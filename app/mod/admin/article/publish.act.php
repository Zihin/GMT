<?php
/***************************************************************
 * 发布新资讯
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/formelem.php';
include_once LIB_DIR.'/common/category.php';

class Publish extends Page{
	var $db;
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.'article';
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$this->input = trimArr($this->input);
		$data = stripQuotes($this->input['item']);
		if(!$this->input['submit']){
			$data['pub_time'] = date('Y-m-d');
			$this->showForm($data);
			return;
		}
		if($eMsg = $this->validate($data)){
			$this->showform($data,$eMsg);
			return;
		}
		if(!$this->insert($data)){
			Core::raiseMsg('操作失败!,原因未知...');
		}
		Core::redirect(Core::getUrl('showlist'));
	}
	
	function isExist($title){
		$sql = "select count(*) from ".$this->tab." where title='$title'";
		return $this->db->GetOne($sql);
	}
	
	function insert($data){
		$data['editor'] = $this->sess->getUserId();
		$data['put_time'] = time();
		unset($data['id']);
		$sql = "select * from ".$this->tab." where id=-1";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetInsertSQL($rs,$data);
		return $this->db->Execute($sql);
	}
	
	function validate($data){
		$eMsg = array();
		if(!$data['title']){
			$eMsg['title'] = '主题不能为空';
		}else if($this->isExist($data['title'])){
			$eMsg['title'] = '该主题已经存在,请重新输入';
		}
		if(!is_numeric($data['cate'])){
			$eMsg['cate'] = '请选择要发布到的类别';
		}
//		if(!strlen($data['lang'])){
//			$eMsg['lang'] = '请选择该文章的语言类型';
//		}
		if(!strlen($data['content'])){
			$eMsg['content'] = '内容不能为空';
		}
		if($data['cate']){
			$recordNum = $this->db->getOne("select count(*) from $this->tab where cate={$data['cate']}");
			$maxNum = Category::getMax($data['cate']);
			if($maxNum && $maxNum <= $recordNum){
				$eMsg['cate'] = "该类别最多只能发布 {$maxNum} 条信息,目前已经达到了最大值,所以当前的信息无法发布";
			}
		}
		return renderMsg($eMsg);
	}
	function showForm($data,$eMsg=null){
		$data['cate'] = Category::selector(CATE_INFO,'item[cate]',$data['cate'],true,'',false);
		$data['istop'] = Form::radio('item[istop]',array('0'=>'否', '1'=>'是'), $data['istop']);
		$data['preview'] = plugin('loadmedia', $data['pic'], 120, 120);
		$pvar['title'] = '发布文章';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('showlist');
		
		$this->addTplFile('form');
		$this->assign($pvar);
		$this->display();
	}
}
?>
