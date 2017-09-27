<?php
/***************************************************************
 * 切换发布状态
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class State extends Action{
	var $db;
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.'link';
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$id = $this->input['id'];
		if(is_array($id)){
			$idStr = implode(',',$id);	
		}
		else if (!is_numeric($id)) {
			Core::raiseMsg('错误! 没有选定任何项目!');
		}else $idStr = $id;
		
		$val = (int)$this->input['val'];
		
		$sql = 'update '.$this->tab." set state=$val where id in($idStr)";
		$this->db->Execute($sql);
		
		if($this->db->Affected_Rows()){
			removeCache('info','detail',$id);	//清除缓存文件
		}
		Core::redirect(Core::getUrl('showlist','','',true));
	}
}
?>