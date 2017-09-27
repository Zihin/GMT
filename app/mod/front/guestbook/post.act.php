<?php
/***************************************************************
 * 回複客戶留言
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

class Post extends Page{
	var $AuthLevel = ACT_OPEN;
	var $db;
	var $tab = 'guestbook';
	
	function __construct(){
		parent::__construct();
		
		$this->tab = TB_PREFIX.$this->tab;
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$data = trimArr($this->input['item']);
		if(!$this->validate($data)){
			Core::raiseMsg('对不起!请填写名称和联系方式...');
		}
                if(is_array($data['g_know'])){
                $data['g_know'] = implode(' ', $data['g_know']);
                }
		$sql = "select * from ".$this->tab." where id=-1";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetInsertSQL($rs,$data);
		if(!$this->db->Execute($sql)){
			Core::raiseMsg('对不起!留言提交失敗');
		}else
			Core::raiseMsg('你的留言提交成功,謝謝您的留言!',array('返回到留言板'=>Core::getUrl('contacts','default')));
	}
	function validate(&$data){
		if(!$data['g_name']
		  || !$data['g_phone']){
			return false;
		}
		$data['put_time'] = time();
		$data['g_name'] =  str_replace('?','',substr($data['g_name'],0,20));
		$data['g_email'] =  str_replace('?','',substr($data['g_email'],0,50));
		$data['content'] = str_replace('?','',substr($data['content'],0,2000));
		return true;
	}
}
?>