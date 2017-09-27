<?php
/***************************************************************
 * 删除会员帐号
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class MbDel extends Action{
	var $AuthLevel = ACT_NEED_AUTH;
	var $db;
	var $tab = "member";
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
	}
	function process(){
		$id = $this->input['id'];
		if(is_array($id)){
			$id = implode(',',$id);	
		}
		else if (!is_numeric($id)) {
				Core::raiseMsg('错误! 没有选定任何的待删除项!');
		}
		
		$sql = 'delete from '.$this->tab." where id in($id)";
		$this->db->Execute($sql);
		$links = array(
			'返回列表' => Core::getUrl('mblist','','',true),
			'添加会员' => Core::getUrl('mbadd')
			);
		if(!$this->db->Affected_Rows()){
			Core::raiseMsg('没有删除任何记录，可能是你的权限不够',$links);
		}else{
			Core::raiseMsg("成功删除了".$this->db->Affected_Rows()."条记录",$links);
		}
	}
}
?>