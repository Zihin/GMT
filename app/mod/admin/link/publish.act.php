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
		$this->tab = TB_PREFIX.'link';
		
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
			$eMsg['title'] = '标题不能为空';
		}
		if(!strlen($data['link'])){
			$eMsg['link'] = '链接路径不能为空';
		}
		return renderMsg($eMsg);
	}
	function showForm($data,$eMsg=null){
		$data['preview'] = plugin('loadmedia', $data['pic'], 120, 120);
		$pvar['title'] = '发布友情链接';
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
