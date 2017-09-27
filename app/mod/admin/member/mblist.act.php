<?php
/***************************************************************
 * 查看会员列表
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/pager.php';
include_once 'member.lib.php';

class MbList extends Page{
	var $db;
	var $row = 20;
	var $currentPage = 0;
	var $queryData = array();
	var $tab = "member";
	
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
		$pvar['kw']['kw_username'] = $this->input['kw_username'];
		$pvar['kw']['kw_member_code'] = $this->input['kw_member_code'];
		$pvar['kw']['kw_group'] = $this->input['kw_group'];
		$pvar['kw']['kw_is_apply'] = $this->input['kw_is_apply'];
		if(plugin('is_date',$this->input['kw_start_time']))
			$pvar['kw']['kw_start_time'] = $this->input['kw_start_time'];
		if(plugin('is_date',$this->input['kw_end_time']))
			$pvar['kw']['kw_end_time'] = $this->input['kw_end_time'];
		$pvar['kw']['row'] = $this->row;
		$pvar['kw']['page'] = $this->currentPage;

		$sqlWhere = " where 1";
		$sqlWhere .= strlen($this->input['kw_username'])?" and username like('%{$this->input['kw_username']}%')":'';
		$sqlWhere .= strlen($this->input['kw_member_code'])?" and member_code like('%{$this->input['kw_member_code']}%')":'';
		$sqlWhere .= is_numeric($this->input['kw_group'])?" and gid = {$this->input['kw_group']}":'';
		$sqlWhere .= is_numeric($this->input['kw_is_apply'])?" and is_apply = {$this->input['kw_is_apply']}":'';
		$sqlWhere .= $pvar['kw']['kw_start_time'] ?	" and reg_date > ".plugin('unixtime',$pvar['kw']['kw_start_time'],'0:0:0') : '';
		$sqlWhere .= $pvar['kw']['kw_end_time'] ? " and reg_date <= ".plugin('unixtime',$pvar['kw']['kw_end_time'],'23:59:59') : '';
		$sqlOrder = " order by m.reg_date desc, m.id desc";
		$sql = "select m.*,g.title as gid from ".$this->tab." m left join ".TB_PREFIX."mb_group g on m.gid=g.id";
		$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		if(!$rs->RecordCount() && $this->currentPage !=0){
			//将第一页的记录显示出来
			$this->currentPage = 0;
			$rs = $this->db->SelectLimit($sql,$this->row,$this->row * $this->currentPage);
		}
		while(!$rs->EOF){
			$rs->fields['actived'] = $rs->fields['actived']?'<img src="imgs/icon/check.gif" title="已激活">':'<img src="imgs/icon/uncheck.gif" title="未激活">';
			$rs->fields['gid'] = $rs->fields['gid']?$rs->fields['gid']:'<span style="color:red">未分组</span>';
			$rs->fields['reg_date'] = date(DATE_FORMAT,$rs->fields['reg_date']);
			$rs->fields['btns'] = $this->btnModify($rs->fields['id']).$this->btnDel($rs->fields['id']);
			if($rs->fields['is_apply']==1){
				$rs->fields['btns'] .= " <a href=\"".Core::getUrl('mbmodify','',array('id'=>$rs->fields['id']))."\">升级审核</a>";
				$rs->fields['btns'] .= " <a target=\"_blank\" href=\"".Core::getUrl('candidatetest','signup',array('mid'=>$rs->fields['id']))."\">查看学生成绩</a>";
			}
                        if($rs->fields['is_apply']==2){
				$rs->fields['btns'] .= " <a href=\"".Core::getUrl('mbmodify','',array('id'=>$rs->fields['id']))."\">审核通过</a>";
				$rs->fields['btns'] .= " <a  target=\"_blank\" href=\"".Core::getUrl('candidatetest','signup',array('mid'=>$rs->fields['id']))."\">查看学生成绩</a>";
			}
                        if($rs->fields['is_apply']==3){
				$rs->fields['btns'] .= " <a href=\"".Core::getUrl('mbmodify','',array('id'=>$rs->fields['id']))."\">审核未通过</a>";
				$rs->fields['btns'] .= " <a target=\"_blank\"  href=\"".Core::getUrl('candidatetest','signup',array('mid'=>$rs->fields['id']))."\">查看学生成绩</a>";
			}
			$pvar['list'][]=$rs->fields;
			$rs->MoveNext();
		}
		$this->sess->setQueryData($pvar['kw']);
		if ($rs->RecordCount()) {
			$totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
			$pvar['page_index'] = pageIndex(Core::getUrl('','','',true), $totalRecord, $this->currentPage, $this->row);
		}
		$pvar['title'] = '会员帐号列表';
		$pvar['form_act'] = Core::getUrl('','','',true);
		$pvar['mul_op'] = $this->btnMop();
		$pvar['button'] = $this->btnAdd();
		$pvar['group_sel'] = groupSelect('kw_group',$this->input['kw_group']);
		
		$this->addTplFile('mb_list');
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
	function btnAdd(){
		$url = Core::getUrl('mbadd');
		return " <input type='button' onclick=\"location.replace('{$url}');\" value='开通会员帐号' />";
	}
	function btnModify($id){
		return "<a href=\"".Core::getUrl('mbmodify','',array('id'=>$id))."\">修改</a>";
	}
	function btnDel($id){
		$msg = '你确定要删除吗？';
		$url = Core::getUrl('mbdel','',array('id'=>$id));
		return " <a href=\"javascript:if(confirm('{$msg}'))location.replace('{$url}');\">删除</a>";
	}
	function btnMop(){
		$f = "";
		$options = "<option value=''>...</option>\n"
					."<option value='Active'>激活帐号</option>\n"
					."<option value='Disable'>冻结帐号</option>\n"
					."<option value='' disabled='disabled'>------</option>\n"
					."<option value='Del'>删除</option>\n";
		$js_code = "
		<script language='javascript'>
		var f = document.getElementById('main_form');
		function mulop(act){
			if('Active' == act){
				if(confirm('你确定要激活所有选中的会员帐号吗？')){
					f.action='".Core::getUrl('mbstate','',array('val'=>1),true)."';
					f.submit();
				}
			}
			if('Disable' == act){
				if(confirm('你确定要冻结所有选中的会员帐号吗？')){
					f.action='".Core::getUrl('mbstate','',array('val'=>0),true)."';
					f.submit();
				}
			}
			if('Del' == act){
				if(confirm('注意!该操作不可恢复.你确定要删除所有选中的会员帐号吗？')){
					f.action='".Core::getUrl('mbdel','','',true)."';
					f.submit();
				}
			}
			
		}
		</script>";
		return "$js_code<select name='mop' onChange=\"mulop(this.value);\">\n$options</select>";
	}
}
?>
