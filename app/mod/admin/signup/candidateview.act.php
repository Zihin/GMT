<?php
/***************************************************************
 * 预览考生信息
 *
 * @author Aling Xiao
 ***************************************************************/

class CandidateView extends Page{
	var $db;
	var $tab = 'candidate';

	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
	}
	
	function process(){

		$id = $this->input['id'];

		if(!is_numeric($id)){
			Core::raiseMsg('参数错误,没有指定有效的ID号');
		}
		$sql = "select * from $this->tab where id=$id";
		$data = $this->db->GetRow($sql);
		if(!count($data)){
			Core::raiseMsg('页面不存在或者已被删除...');
		}
		$data['put_time'] = date('Y-m-d',$data['put_time']);
		$this->addTplFile('CandidateView');
		$this->assign(stripQuotes($data));
		$this->display();
	}
}
?>