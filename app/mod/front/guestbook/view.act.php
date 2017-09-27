<?php
/***************************************************************
 * 客戶留言列表
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
require_once LIB_DIR.'/common/pager.php';

class View extends Page{
	var $AuthLevel = ACT_OPEN;
	var $db;
	var $row = 8;		//每頁顯示的留言條數
	var $currentPage = 0;
	var $queryData = array();
	var $tab = 'guestbook';
	
	function __construct(){
		parent::__construct();
		
		$this->tab = TB_PREFIX.$this->tab;
		$this->db = Core::getDb();
		//$this->db->debug = true;
		
		$this->currentPage = $this->input['page'];
	}
	function process(){
		$pvar = array();
		
		$sqlOrder = " order by put_time desc,id desc";
		$sql = "select * from $this->tab where state=1";
		
		$rs = $this->db->SelectLimit($sql.$sqlOrder,$this->row,$this->row * $this->currentPage);
		if(!$rs->RecordCount() && $this->currentPage !=0){
			//將第一頁的記錄顯示出來
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
			$rs->fields['put_time'] = date('Y年m月d日',$rs->fields['put_time']);
			$rs->fields['reply_time'] = date('Y年m月d日',$rs->fields['reply_time']);
			$pvar['list'][]=$rs->fields;
			$rs->MoveNext();
		}
		if ($rs->RecordCount()) {
			$totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql));
			$pvar['page_index'] = pageIndex(Core::getUrl('','','',true), $totalRecord, $this->currentPage, $this->row);
		}
		
		$pvar['self_id'] = 'guestbook';
		$this->addTplFile('view');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
}
?>
