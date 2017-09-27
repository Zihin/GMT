<?php
/***************************************************************
 * 回复客户留言
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

class Reply extends Page{
	var $db;
	var $tab = 'guestbook';
	
	function __construct(){
		parent::__construct();
		
		$this->tab = TB_PREFIX.$this->tab;
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}

	function process(){
		if(!is_numeric($this->input['id'])){
			Core::raiseMsg('参数错误,请返回操作...');
		}
		if(empty($this->input['submit'])){
			$this->showForm();
			return;
		}
		$data = trimArr($this->input['item']);
		$this->updateDb($this->input['id'],$data);
		Core::redirect(Core::getUrl('showlist','','',true));
	}
	function showForm(){
		$pvar['title'] = '回复客户留言';
		$pvar['item'] = $this->getMessage();
		$pvar['goback'] = Core::getUrl('ShowList','','',true);
		
		$this->addTplFile('reply_form');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	function getMessage(){
		$sql = "select * from ".$this->tab." where id = {$this->input['id']}";
		$data = $this->db->GetRow($sql);
		$data['subject'] = textFormat($data['subject']);
		$data['content'] = textFormat($data['content']);
		$data['reply'] = textFormat($data['reply']);
		$data['g_name'] = textFormat($data['g_name']);
		$data['g_email'] = textFormat($data['g_email']);
		$data['g_phone'] = textFormat($data['g_phone']);
		$data['g_addr'] = textFormat($data['g_addr']);
		$data['g_photo'] = ('先生' == $data['g_sex'])?'sex_m.gif':'sex_f.gif'; 
		$data['put_time'] = date('Y-m-d h:i',$data['put_time']);
		return $data;
	}
	function updateDb($id,$data){
		$data['reply_time'] = time();
		$sql = "select * from ".$this->tab." where id = $id";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs,$data);
		$this->db->Execute($sql);
	}
}
?>
