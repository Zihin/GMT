<?php
/***************************************************************
 * 批量订购单 
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
require_once LIB_DIR.'/common/pager.php';
require_once LIB_DIR.'/common/formelem.php';

class ShowList extends Page{
	var $db;
	var $row = 20;
	var $currentPage = 0;
	var $queryData = array();
	var $tab = 'orderform';
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
		
		$this->setRowPrePage($this->input['row']);
		$this->setCurrentPage($this->input['page']);
	}
	function process(){
		$pvar = array();
		$pvar['kw']['kw_name'] = $this->input['kw_name'];
		$pvar['kw']['row'] = $this->row;

		$sqlWhere = " where 1";
		$sqlWhere .= strlen($this->input['kw_name'])?" and name like('%{$this->input['kw_name']}%')":'';
		$sqlOrder = " order by id desc";
		$sql = "select * from ".$this->tab;
		
		$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		if(!$rs->RecordCount() && $this->currentPage !=0){
			//将第一页的记录显示出来
			$this->currentPage = 0;
			$rs = $this->db->SelectLimit($sql,$this->row,$this->row * $this->currentPage);
		}
		while(!$rs->EOF){
			$rs->fields = utf8Decode($rs->fields);
			$rs->fields['put_time'] = date('Y-m-d h:i',$rs->fields['put_time']);
			$rs->fields['btns'] = $this->btnDetail($rs->fields['id']).$this->btnDel($rs->fields['id']);
			$pvar['list'][]=$rs->fields;
			$rs->MoveNext();
		}
		$pvar['kw']['page'] = $this->input['page'];
		$this->sess->setQueryData($pvar['kw']);
		if ($rs->RecordCount()) {
			$totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
			$pvar['page_index'] = pageIndex(Core::getUrl('','','',true), $totalRecord, $this->currentPage, $this->row);
		}
		$pvar['title'] = '批量订购单';
		$pvar['form_act'] = Core::getUrl();
		$pvar['mul_op'] = $this->btnMop();
		
		$this->addTplFile('list');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	function setRowPrePage($row){
		if(is_numeric($row) && $row <= 100){
			$this->row = $row;
		}
	}
	function setCurrentPage($page){
		if(is_numeric($page)){
			$this->currentPage = $page;
		}
	}
	function btnDetail($id){
		return "<a href=\"".Core::getUrl('detail','',array('id'=>$id))."\">详细</a>";
	}
	function btnDel($id){
		$msg = '你确定要删除吗？';
		$url = Core::getUrl('Delete','',array('id'=>$id));
		return " <a href='#' onclick=\"if(confirm('{$msg}'))location.replace('{$url}');\">删除</a>";
	}
	function btnMop(){
		$msg = '注意!此操作不可恢复,你确定要删除吗？';
		$url = Core::getUrl('delete');
		return " <input type='button' onclick=\"if(confirm('{$msg}')){main_form.action='{$url}';main_form.submit();}\" value='删除' />";
	}
}
?>
