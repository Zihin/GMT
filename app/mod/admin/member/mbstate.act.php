<?php
/***************************************************************
 * 切换会员帐号的激活状态
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class MbState extends Action{
	var $db;
	var $tab = "member";
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$id = $this->input['id'];
		if(is_array($id)){
			$id = implode(',',$id);	
		}
		else if (!is_numeric($id)) {
				Core::raiseMsg('错误! 没有选定任何的待删除项!');
		}
		$val = (int)$this->input['val'];
		
		$sql = 'update '.$this->tab." set actived=$val where id in($id)";
		$this->db->Execute($sql);
		Core::redirect(Core::getUrl('mblist','','',true));
	}
}
?>