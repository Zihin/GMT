<?php
/***************************************************************
 * 查看订单列表
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
	var $tab = 'pd_order';
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
		$this->setRowPrePage($this->input['row']);
		$this->setCurrentPage($this->input['page']);
	}
	function process(){
		$this->input = trimArr($this->input);
		$pvar = array();
		
		$pvar['kw']['row'] = $this->row;
		if(is_numeric($this->input['sn']))
			$pvar['kw']['sn'] = $this->input['sn'];
		if($this->input['name'])
			$pvar['kw']['name'] = $this->input['name'];
		if($this->input['name'])
			$pvar['kw']['name'] = $this->input['name'];
		if($this->input['area'])
			$pvar['kw']['area'] = $this->input['area'];
		if(is_numeric($this->input['state']))
			$pvar['kw']['state'] = $this->input['state'];
		if(plugin('is_date',$this->input['kw_start_time']))
			$pvar['kw']['kw_start_time'] = $this->input['kw_start_time'];
		if(plugin('is_date',$this->input['kw_end_time']))
			$pvar['kw']['kw_end_time'] = $this->input['kw_end_time'];

		$sqlWhere = " where 1";
		$sqlWhere .= is_numeric($pvar['kw']['sn'])?" and sn={$pvar['kw']['sn']}":'';
		$sqlWhere .= $pvar['kw']['area']? " and area='{$pvar['kw']['area']}'" : '';
		$sqlWhere .= is_numeric($pvar['kw']['state'])?" and state={$pvar['kw']['state']}":'';
		$sqlWhere .= $pvar['kw']['kw_start_time'] ?	" and put_time > ".plugin('unixtime',$pvar['kw']['kw_start_time'],'0:0:0') : '';
		$sqlWhere .= $pvar['kw']['kw_end_time'] ? " and put_time <= ".plugin('unixtime',$pvar['kw']['kw_end_time'],'23:59:59') : '';
		
		$sqlOrder = " order by put_time desc";
		$sql = "select * from ".$this->tab;
		
		$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		if(!$rs->RecordCount() && $this->currentPage !=0){
			//将第一页的记录显示出来
			$this->currentPage = 0;
			$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		}
		while(!$rs->EOF){
			$rs->fields['name'] .= $rs->fields['mid']? "(会员)": "(非会员)";
			$rs->fields['put_time'] = date(DATE_FORMAT,$rs->fields['put_time']);
			$rs->fields['btns'] = $this->btnDetail($rs->fields['sn'])
					.$this->btnProc($rs->fields['sn'],$rs->fields['state']);
					//.$this->btnDel($rs->fields['sn']);
			$pvar['list'][]=$rs->fields;
			$rs->MoveNext();
		}
		$pvar['kw']['page'] = $this->input['page'];
		$this->sess->setQueryData($pvar['kw']);
		if ($rs->RecordCount()) {
			$totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
			$pvar['page_index'] = pageIndex(Core::getUrl('','','',true), $totalRecord, $this->currentPage, $this->row);
		}
		$pvar['area'] = plugin('areaselector','area',$pvar['kw']['area']);
		$pvar['state'] = Form::select('state',$GLOBALS['order_state'],$pvar['kw']['state']);
		$pvar['title'] = '订单列表';
		$pvar['form_act'] = Core::getUrl('','','',true);
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
	
	function btnDetail($sn){
		return " <a href=\"".Core::getUrl('detail','',array('sn'=>$sn))."\">详细</a>";
	}
	function btnProc($sn, $state){
		if(!$state)
			return " <a href=\"".Core::getUrl('proc','',array('sn'=>$sn))."\">处理订单</a>";
	}
	function btnDel($sn){
		$msg = '你确定要撤消该订单吗？';
		$url = Core::getUrl('Delete','',array('sn'=>$sn));
		return " <a href='#' onclick=\"if(confirm('{$msg}'))location.replace('{$url}');\">删除</a>";
	}
	function btnMop(){
		$f = "";
		$options = "<option value=''>...</option>\n"
					."<option value='cancel'>撤消订单</option>\n"
					."<option value='getback'>恢复订单</option>\n"
					."<option value='delete'>删除订单</option>\n";
					//."<option value='' disabled='disabled'>------</option>\n";
		$js_code = "
		<script language='javascript'>
		var f = document.getElementById('main_form');
		function mulop(act){
			if('cancel' == act){
				if(confirm('你确定要撤消所有选中的订单吗？')){
					f.action='".Core::getUrl('cancel','',array('val'=>-1),true)."';
					f.submit();
				}
			}
			if('getback' == act){
				if(confirm('你确定要恢复所有选中的订单吗？')){
					f.action='".Core::getUrl('cancel','',array('val'=>0),true)."';
					f.submit();
				}
			}
			if('delete' == act){
				if(confirm('注意!该操作不可恢复.你确定要删除所有的选中项吗？')){
					f.action='".Core::getUrl('delete')."';
					f.submit();
				}
			}

		}
		</script>";
		return "$js_code<select name='mop' onChange=\"mulop(this.value);\">\n$options</select>";
	}
}
?>
