<?php
/***************************************************************
 * 查看批量订购单详细信息
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

class Detail extends Page{
	var $db;
	var $tab = 'orderform';
	
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
		$pvar['title'] = '批量订购单详细内容';
		$pvar['item'] = $this->getData();
		$pvar['goback'] = Core::getUrl('showlist','','',true);
		
		$this->addTplFile('detail');
		$this->assign($pvar);
		$this->display();
	}
	function getData(){
		$sql = "select * from ".$this->tab." where id = {$this->input['id']}";
		$data = utf8Decode($this->db->GetRow($sql));
		$put_time = date(DATE_FORMAT, $data['put_time']);
		$data = unserialize($data['content']);
		$data['put_time'] = $put_time;
		return $data;
	}
}
?>
