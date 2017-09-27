<?php
/***************************************************************
 * 查看订单详细内容
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/formelem.php';
include_once LIB_DIR.'/common/category.php';

class Detail extends Page{
	var $db;
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.'pd_order';
		$this->tab_list = TB_PREFIX.'pd_order_list';
		$this->tab_user = TB_PREFIX.'sys_user';
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$this->input = trimArr($this->input);
		$sn = $this->input['sn'];
		$data = stripQuotes($this->input['item']);
		if(!$sn){
			Core::raiseMsg('错误!没有指定订单编号');
		}
		$data = $this->getData($sn);
		
		$pvar = array();
		$pvar['state'] = $GLOBALS['order_state'][$data['state']];
		$pvar['btnPrint'] = Core::getUrl('','',array('sn'=>$sn,'print'=>1));
		$pvar['title'] = "订单'".snFormat($sn)."'的详细内容";
		$pvar['item'] = $data;
		$pvar['goback'] = Core::getUrl('showlist','','',true);
		
		if(isset($this->input['print']))
			$this->addTplFile('print');
		else
			$this->addTplFile('detail');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	
	function getData($sn){
		$sql = "select * from ".$this->tab." where sn='$sn'";
		$data = $this->db->GetRow($sql);
		$data['put_time'] = date(DATE_FORMAT_L, $data['put_time']);
		$data['proc_time'] = date(DATE_FORMAT_L, $data['proc_time']);
		
		if($data['handler']){
			$data['handler'] = $this->db->GetOne("select username from $this->tab_user where id=".$data['handler']);
		}
		$sql = "select * from $this->tab_list where order_sn='$sn'";
		$rs = $this->db->Execute($sql);
		$data['total'] = 0;
		while(!$rs->EOF){
			$rs->fields['count'] = $rs->fields['price'] * $rs->fields['quanlity'];
			$data['total'] += $rs->fields['count'];
			$data['list'][] = $rs->fields;
			$rs->MoveNext();
		}
		return $data;
	}
}
?>
