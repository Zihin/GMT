<?php
/***************************************************************
 * 订单处理
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/formelem.php';
include_once LIB_DIR.'/common/category.php';

class Proc extends Page{
	var $db;
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.'pd_order';
		$this->tab_list = TB_PREFIX.'pd_order_list';
		$this->tab_user = TB_PREFIX.'pd_sys_user';
		$this->tab_storage = TB_PREFIX.'pd_storage';
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$this->input = trimArr($this->input);
		$data = stripQuotes($this->input['item']);
		$sn = $this->input['sn']?$this->input['sn'] : $data['sn'];
		if(!$sn){
			Core::raiseMsg('错误!没有指定订单编号');
		}
		if(empty($this->input['btnSubmit'])){
			$data['sn'] = $sn;
			$this->showForm($data);
			return;
		}
		if($emsg = $this->validate($data)){
			$this->showForm($data,$emsg);
			return;
		}
		if(!$this->update($sn,$data)){
			$this->showForm($data, array('msg'=>'提交处理结果异常,请重试'));
			return;
		}
		$print = Core::getUrl('detail','',array('sn'=>$sn,'print'=>1));
		$links = array(	'打印订单'=>"javascript:winOpen('$print',520,460,1);location.replace('".Core::getUrl('detail','',array('sn'=>$sn))."');"
						,'返回列表'=>Core::getUrl('showlist','','',true));
		Core::raiseMsg('订单处理完毕<script src="scripts/utils.js"></script>',$links);
	}
	function validate(&$data){
		$emsg = array();
		if(!$data['proc_result']){
			$emsg['proc_result'] = '请填写处理结果或意见';
		}
		return renderMsg($emsg);
	}
	function update($sn,$data){
		
		//补充订单处理信息
		$data['state'] = 1;
		$data['proc_time'] = time();
		$data['handler'] = $this->sess->getUserId();
		
		//更新订单状态
		$sql = "select state,proc_time,proc_result,handler from $this->tab where sn = '$sn'";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs, $data);
		return $this->db->Execute($sql);
	}
	function getData($sn){
		$sql = "select * from ".$this->tab." where sn='$sn'";
		$data = $this->db->GetRow($sql);

		$data['put_time'] = date(DATE_FORMAT_L, $data['put_time']);
		
		$sql = "select * from $this->tab_list where order_sn='$sn'";
		$rs = $this->db->Execute($sql);
		$data['total'] = 0;
		while(!$rs->EOF){
			$rs->fields['count'] = $rs->fields['price'] * $rs->fields['quanlity'];
			$data['total'] += $rs->fields['count'];
			$data['list'][] = $rs->fields;
			$rs->MoveNext();
		}
		if(0 != $data['state']) Core::raiseMsg('该订单已经完成或已被撤消,无法进行处理...');
		return $data;
	}
	function showForm($data,$emsg = null){
		//vardump($data);
		$pvar = array();
		$pvar['emsg'] = $emsg;
		$pvar['state'] = Form::select('state',$GLOBALS['order_state'],$data['state']);
		$pvar['btnPrint'] = Core::getUrl('detail','',array('sn'=>$data['sn'],'print'=>1));
		$pvar['title'] = "正在处理订单'".snFormat($data['sn'])."'";
		$pvar['info'] = $this->getData($data['sn']);
		$pvar['item'] = $data;
		$pvar['goback'] = Core::getUrl('showlist','','',true);
		$pvar['cancel'] = Core::getUrl('cancel','',array('sn'=>$data['sn'],'val'=>-1),true);
		
		if(isset($this->input['print']))
			$this->addTplFile('print');
		else
			$this->addTplFile('form');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
}
?>
