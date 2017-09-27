<?php
/***************************************************************
 * 客户留言列表
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
require_once LIB_DIR.'/common/pager.php';
require_once LIB_DIR.'/common/formelem.php';

class ShowList extends Page{
	var $db;
	var $row = 5;
	var $currentPage = 0;
	var $queryData = array();
	var $tab = 'guestbook';
	
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
		$pvar['kw']['kw_subject'] = $this->input['kw_subject'];
		$pvar['kw']['kw_name'] = $this->input['kw_name'];
		$pvar['kw']['kw_noreply'] = $this->input['kw_noreply'];
		$pvar['kw']['row'] = $this->row;

		$sqlWhere = " where 1";
		$sqlWhere .= strlen($this->input['kw_subject'])?" and subject like('%".$this->input['kw_subject']."%')":'';
		$sqlWhere .= strlen($this->input['kw_name'])?" and g_name like('%".$this->input['kw_name']."%')":'';
		$sqlWhere .= is_numeric($this->input['kw_noreply'])?" and (reply='' or reply_time=0)":'';
		$sqlOrder = " order by put_time desc,id desc";
		$sql = "select * from ".$this->tab;
		
		$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		if(!$rs->RecordCount() && $this->currentPage !=0){
			//将第一页的记录显示出来
			$this->currentPage = 0;
			$rs = $this->db->SelectLimit($sql,$this->row,$this->row * $this->currentPage);
		}
		while(!$rs->EOF){
			$rs->fields['subject'] = textFormat($rs->fields['subject']);
			$rs->fields['content'] = textFormat($rs->fields['content']);
			$rs->fields['reply'] = textFormat($rs->fields['reply']);
			$rs->fields['g_name'] = textFormat($rs->fields['g_name']);
			$rs->fields['g_email'] = textFormat($rs->fields['g_email']);
			$rs->fields['g_phone'] = textFormat($rs->fields['g_phone']);
			$rs->fields['g_addr'] = textFormat($rs->fields['g_addr']);
			$rs->fields['g_photo'] = ('先生' == $rs->fields['g_sex'])?'sex_m.gif':'sex_f.gif';
			$rs->fields['put_time'] = date('Y-m-d h:i',$rs->fields['put_time']);
			$rs->fields['reply_time'] = date('Y-m-d h:i',$rs->fields['reply_time']);
			$rs->fields['btns'] = $this->btnDel($rs->fields['id']);
			$pvar['list'][]=$rs->fields;
			$rs->MoveNext();
		}
		$pvar['kw']['page'] = $this->input['page'];
		$this->sess->setQueryData($pvar['kw']);
		if ($rs->RecordCount()) {
			$totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
			$pvar['page_index'] = pageIndex(Core::getUrl('','','',true), $totalRecord, $this->currentPage, $this->row);
		}
		$pvar['title'] = '客户留言';
		$pvar['noreply'] = Form::checkbox('kw_noreply',array(1=>'只显示未回复的留言'),$this->input['kw_noreply']);
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
	function btnReply($id){
		return "<a href=\"".Core::getUrl('Reply','',array('id'=>$id))."\">回复</a>";
	}
	function btnDel($id){
		$msg = '你确定要删除吗？';
		$url = Core::getUrl('Delete','',array('id'=>$id));
		return " <a href='#' onclick=\"if(confirm('{$msg}'))location.replace('{$url}');\">删除</a>";
	}
	function btnMop(){
		$f = "";
		$options = "<option value=''>...</option>\n"
					."<option value='Public'>公开</option>\n"
					."<option value='Disable'>不公开</option>\n"
					."<option value='' disabled='disabled'>------</option>\n"
					."<option value='Del'>删除</option>\n";
		$js_code = "
		<script language='javascript'>
		var f = document.getElementById('main_form');
		function mulop(act){
			if('Public' == act){
				if(confirm('你确定要公开所有的选中项吗？')){
					f.action='".Core::getUrl('state','',array('val'=>1),true)."';
					f.submit();
				}
			}
			if('Disable' == act){
				if(confirm('你确定要不公开所有的选中项吗？')){
					f.action='".Core::getUrl('state','',array('val'=>0),true)."';
					f.submit();
				}
			}
			if('Del' == act){
				if(confirm('注意!该操作不可恢复.你确定要删除所有的选中项吗？')){
					f.action='".Core::getUrl('delete','','',true)."';
					f.submit();
				}
			}
		}
		</script>";
		return "$js_code<select name='mop' onChange=\"mulop(this.value);\">\n$options</select>";
	}
}
?>
