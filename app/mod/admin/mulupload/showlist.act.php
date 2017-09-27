<?php
/***************************************************************
 * 查看产品
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/pager.php';
include_once LIB_DIR.'/common/category.php';
include_once LIB_DIR.'/common/formelem.php';
class ShowList extends Page{
	var $db;
	var $row = 20;
	var $currentPage = 0;
	var $queryData = array();
	var $tab = "images";
	
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
		$pvar['kw']['row'] = $this->row;
		if(is_numeric($this->input['page']))
			$pvar['kw']['page'] = $this->input['page'];
		
		$assoc_id = strlen($this->input['assoc_id'])? $this->input['assoc_id'] : $data['assoc_id'];
                $cate_id = strlen($this->input['cate_id'])? $this->input['cate_id'] : $data['cate_id'];
		
	
		$sqlWhere = " where 1";
		$sqlWhere .= strlen($assoc_id) ? " and assoc_id = '".$assoc_id."'" : '';
		$sqlOrder = " order by id desc";
		$sql = "select * from ".$this->tab;
		
		$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		if(!$rs->RecordCount() && $this->currentPage !=0){
			//将第一页的记录显示出来
			$this->currentPage = 0;
			$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		}
		while(!$rs->EOF){
			$rs->fields['put_time'] = date(DATE_FORMAT,$rs->fields['put_time']);
			$rs->fields['btns'] = $this->btnDel($rs->fields['id'],$assoc_id,$cate_id);
			
			$pvar['list'][]=$rs->fields;
			$rs->MoveNext();
		}
		
		$this->sess->setQueryData($pvar['kw']);
		
		if ($rs->RecordCount()) {
			$totalRecord = $this->db->GetOne("select count(*) as total from $this->tab $sqlWhere");
			//$totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
			$pvar['page_index'] = pageIndex(Core::getUrl('','','',true), $totalRecord, $this->currentPage, $this->row);
		}
		$pvar['title'] = '查看图片列表';
		$pvar['form_act'] = Core::getUrl('','','',true);
		$pvar['mul_op'] = $this->btnMop($assoc_id,$cate_id);
                if(strlen($assoc_id)){
		$pvar['button'] = $this->btnPublish($assoc_id,$cate_id);
                }
		
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
	function btnPublish($assoc_id,$cate_id){
                $url = Core::getUrl('publish','mulupload',array('assoc_id'=>$assoc_id,'cate_id'=>$cate_id));
		return " <input type='button' onclick=\"location.replace('{$url}');\" value='上传图片' />";
	}
	function btnDel($id,$assoc_id,$cate_id){
		$msg = '你确定要删除吗？';
		$url = Core::getUrl('delete','',array('id'=>$id, 'assoc_id'=>$assoc_id,'cate_id'=>$cate_id));
		return " <a href=\"javascript:if(confirm('{$msg}'))location.replace('{$url}');\"> 删除</a>";
	}
	function btnMop($assoc_id,$cate_id) {
		$msg= '注意!此操作不可恢复,你确定要删除吗？';
		$url= Core :: getUrl('delete', '', array ('assoc_id'=>$assoc_id,'cate_id'=>$cate_id));
		return " <input type='button' onclick=\"if(confirm('{$msg}')){main_form.action='{$url}';main_form.submit();}\" value='删除' />";
	}

}
?>
