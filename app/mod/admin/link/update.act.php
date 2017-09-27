<?php
/***************************************************************
 * 修改资讯内容
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/formelem.php';
include_once LIB_DIR.'/common/category.php';

class Update extends Page{
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
		$id = is_numeric($this->input['id'])? $this->input['id'] : $data['id'];
		if(!is_numeric($id)){
			Core::raiseMsg('错误!没有指定ID号');
		}
		if(empty($this->input['submit'])){
			$data = stripQuotes($this->getData($id));
			$this->showForm($data);
			return;
		}
		$data['id'] = $id;
		if($eMsg = $this->validate($data)){
			$this->showForm($data,$eMsg);
			return;
		}
		
		$this->updateDb($id,$data);
		
		if($this->db->Affected_Rows()){
			removeCache('info','detail',$id);	//清除缓存文件
		}
		
		Core::redirect(Core::getUrl('showlist','','',true));
	}
	
	function getData($id){
		$sql = "select * from ".$this->tab." where id=$id";
		$data = $this->db->GetRow($sql);
		$data['pub_time'] = date(DATE_FORMAT,$data['pub_time']);
		return $data;
	}
	
	function updateDb($id,$data){
		unset($data['id']);	//防止ID号被修改
		$sql = "select * from ".$this->tab." where id=$id";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs,$data);
		return $this->db->Execute($sql);
	}
	
	function showForm($data,$eMsg=null){
		
		$data['preview'] = plugin('loadmedia', $data['pic'], 120, 120);
		$pvar['title'] = '编辑友情链接';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('showlist','','',true);
		
		$this->addTplFile('form');
		$this->assign($pvar);
		$this->display($pvar);
	}

	function isExist($title, $me){
		$sql = "select count(*) from ".$this->tab
			." where title='$title' and id <>$me";
		if($this->db->GetOne($sql)){	
			return true;
		}
		return false;
	}
	
	function validate($data){
		$eMsg = array();
	
		if(!$data['title']){
			$eMsg['title'] = '标题不能为空';
		}
		if(!strlen($data['link'])){
			$eMsg['link'] = '链接路径不能为空';
		}
		$eMsg = renderMsg($eMsg);
		return $eMsg;
	}
}
?>
