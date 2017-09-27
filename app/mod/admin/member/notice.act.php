<?php
/***************************************************************
 * 会员区公告
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/pager.php';
class Notice extends Page {
	var $db;
	var $tab = "mb_notice";
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		switch($this->input['act']){
			case 'add':{
				$this->add();
			}
			break;
			case 'update':{
				$this->update();
			}
			break;
			case 'del':{
				$this->del();
			}
			break;
			default:{
				$this->ShowList();
			}
		}
	}
	function ShowList(){
		$this->input = trimArr($this->input);
		$currentPage = is_numeric($this->input['page'])?$this->input['page']:0;
		$row = (is_numeric($this->input['row']) && $this->input['row'] <=100)?$this->input['row']:20;
		$sqlWhere = " where 1";
		if(strlen($this->input['kw_title'])){
			$pvar['kw']['kw_title'] = $this->input['kw_title'];
			$sqlWhere .= " and title like('%{$this->input['kw_title']}%')";
		}
		$sqlOrder = " order by title";
		$sql = "select * from ".$this->tab;
		$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder, $row, $row * $currentPage);
		if(!$rs->RecordCount() && $currentPage !=0){
			//将第一页的记录显示出来
			$currentPage = 0;
			$rs = $this->db->SelectLimit($sql.$sqlWhere, $row, $row * $currentPage);
		}
		$list = array();
		while(!$rs->EOF){
			$rs->fields['editor'] = $this->db->GetOne('select username from '.TB_PREFIX.'sys_user where id='.$rs->fields['editor']);
			$rs->fields['put_time'] = date(DATE_FORMAT, $rs->fields['put_time']);
			$rs->fields['btns'] = $this->btnUpdate($rs->fields['id'])
					.$this->btnDel($rs->fields['id']);
			$pvar['list'][] = $rs->fields;
			$rs->MoveNext();
		}
		$pvar['kw']['row'] = $row;
		$pvar['kw']['page'] = $currentPage;
		$this->sess->setQueryData($pvar['kw']);
		if ($rs->RecordCount()) {
			$totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
			$pvar['page_index'] = pageIndex(Core::getUrl('','','',true), $totalRecord, $currentPage, $row);
		}
		$pvar['title'] = '会员区公告';
		$pvar['form_act'] = Core::getUrl('','','',true);
		$pvar['button'] = $this->btnAdd();
		$pvar['mul_op'] = $this->btnMop();
		
		$this->addTplFile('notice_list');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	function add(){
		$this->input = trimArr($this->input);
		$data = $this->input['item'];
		if(empty($this->input['submit'])){
			$this->showForm($this->input['act'],$data);
			return;
		}
		if($emsg = $this->validate($data)){
			$this->showForm($this->input['act'],$data,$emsg);
			return;
		}
		unset($data['id']);
		$data['put_time'] = time();
		$data['editor'] = $this->sess->getUserId();
		$sql = "select * from ".$this->tab." where id = -1";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetInsertSQL($rs, $data);
		if(!$this->db->Execute($sql)){
			Core::raiseMsg('插入数据失败,原因未知');
		}
		Core::redirect(Core::getUrl('','','',true));
	}
	function update(){
		$data = $this->input['item'];
		$id = $this->input['id']? $this->input['id'] : $data['id'];
		if(!is_numeric($id)){
			Core::raiseMsg('错误!没有指定待修改项的ID');
		}
		if(empty($this->input['submit'])){
			$data = $this->getData($id);
			$this->showForm($this->input['act'],$data);
			return;
		}
		if($emsg = $this->validate($data)){
			$this->showForm($this->input['act'],$data,$emsg);
			return;
		}
		$sql = "select * from ".$this->tab." where id = $id";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs, $data);
		$this->db->Execute($sql);		
		Core::redirect(Core::getUrl('','','',true));
	}
	function del(){
		$id = $this->input['id'];
		if(is_array($id)){
			$id = implode(',',$id);	
		}
		else if (!is_numeric($id)) {
			Core::raiseMsg('错误! 没有选定任何的待删除项!');
		}
		$sql = 'delete from '.$this->tab." where id in($id)";
		$this->db->Execute($sql);
		
		Core::redirect(Core::getUrl('','','',true));
	}
	function getData($id){
		$sql = "select * from ".$this->tab." where id=$id";
		return $this->db->GetRow($sql);
	}
	function showForm($act, $data, $emsg=null){
		if('update' == $act){
			$title = '编辑公告内容';
			$form_act = Core::getUrl('','',array('act' => $act));
		}else {
			$title = '发布新公告';
			$form_act = Core::getUrl('','',array('act' => $act));
		}
		$pvar['title'] = $title;
		$pvar['item'] = $data;
		$pvar['emsg'] = $emsg;
		$pvar['form_act'] = $form_act;
		$pvar['goback'] = Core::getUrl('','','',true);
		
		$this->addTplFile('notice_form');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	function validate($data){
		$emsg = array();
		if(!strlen($data['title'])){
			$emsg['title'] = '标题不能为空';
		}
		if(!strlen($data['content'])){
			$emsg['content'] = '请填写内容';
		}
		return renderMsg($emsg);
	}
	function btnAdd(){
		$url = Core::getUrl('','',array('act'=>'add'));
		return " <input type='button' onclick=\"location.replace('{$url}');\" value='发布新公告' />";
	}
	function btnUpdate($id){
		return "<a href=\"javascript:location.replace('".Core::getUrl('','',array('act'=>'update','id'=>$id))."');\">修改</a>";
	}
	function btnDel($id){
		$msg = '你确定要删除吗？';
		$url = Core::getUrl('','',array('act'=>'del','id'=>$id));
		return " <a href=\"javascript:if(confirm('{$msg}'))location.replace('{$url}');\">删除</a>";
	}
	function btnMop(){
		$msg = '注意!此操作不可恢复,你确定要删除吗？';
		$url = Core::getUrl('','',array('act'=>'del'));
		return " <input type='button' onclick=\"if(confirm('{$msg}')){main_form.action='{$url}';main_form.submit();}\" value='删除' />";
	}
}
?>
