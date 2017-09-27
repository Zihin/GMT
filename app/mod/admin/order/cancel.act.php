<?php
/***************************************************************
 * 撤消/恢复状态
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class Cancel extends Action{
	var $db;
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.'pd_order';
		
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
		
		$val = (int)$this->input['val'];
		if(0 == $val || -1 == $val){
			$sql = 'update '.$this->tab." set state=$val where sn in($snStr) and (state=-1 or state=0)";
			$this->db->Execute($sql);
		}	
		Core::redirect(Core::getUrl('showlist','','',true));
	}
}
?>