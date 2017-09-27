<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
/***************************************************************
 * 修改资讯内容
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/formelem.php';
include_once LIB_DIR.'/common/category.php';

class Company_Info extends Page{
	var $db;
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.'config';
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$this->input = trimArr($this->input);
		$data = stripQuotes($this->input['item']);
		$id = 1;
		if(empty($this->input['submit'])){
			$data = stripQuotes($this->getData($id));
			$this->showForm($data);
			return;
		}
		$data['id'] = $id;
	
		
		$this->updateDb($id,$data);
		
		if($this->db->Affected_Rows()){
			removeCache('info','detail',$id);	//清除缓存文件
		}
		
		Core::redirect(Core::getUrl('company_info','','',true));
	}
	
	function getData($id){
		$sql = "select * from ".$this->tab." where id=$id";
		$data = $this->db->GetRow($sql);
		$data['pub_time'] = date(DATE_FORMAT,$data['pub_time']);
		return $data;
	}
	
	function updateDb($id,$data){
		unset($data['id']);	//防止ID号被修改
		$data['put_time'] = time();
		$sql = "select * from ".$this->tab." where id=$id";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs,$data);
		return $this->db->Execute($sql);
	}
	
	function showForm($data,$eMsg=null){
		$data['cate'] = Category::selector(CATE_INFO,'item[cate]',$data['cate'],true,'',false);
		$data['istop'] = Form::radio('item[istop]',array('0'=>'否', '1'=>'是'), $data['istop']);
		$data['preview'] = plugin('loadmedia', $data['pic'], 120, 120);
		$pvar['title'] = '系统基本信息维护';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('company_info','','',true);
		
		$this->addTplFile('company_info');
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

}
?>
