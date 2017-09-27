<?php
/***************************************************************
 * 撤消/恢复状态
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class Delete extends Action{
	var $db;
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.'pd_order';
		$this->tab_d = TB_PREFIX.'pd_order_list';
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$sn = $this->input['sn'];
		if(is_array($sn)){
			foreach($sn as $v){
				$snStr .= "'$v',";
			}
			$snStr = substr($snStr, 0 ,-1);
		}else $snStr = "'$sn'";
		
		$sql = 'delete from '.$this->tab_d." where order_sn in($snStr)";
		$this->db->Execute($sql);
		
		$sql = 'delete from '.$this->tab." where sn in($snStr)";
		$this->db->Execute($sql);
		$links = array(
			'返回列表' => Core::getUrl('showlist','','',true));
		if(!$this->db->Affected_Rows()){
			Core::raiseMsg('没有删除任何记录，可能是你的权限不够',$links);
		}else{
			Core::raiseMsg("成功删除了".$this->db->Affected_Rows()."条记录",$links);
		}
		Core::redirect(Core::getUrl('showlist','','',true));
	}
}
?>
