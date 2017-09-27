<?php
/***************************************************************
 * 查看资讯列表
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/pager.php';
include_once LIB_DIR.'/common/category.php';
include_once LIB_DIR.'/common/formelem.php';
class ShowList extends Page{
	var $db;
	var $row = 21;
	var $currentPage = 0;
	var $queryData = array();
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.'link';
		
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
		if(is_numeric($this->input['kw_state']))
			$pvar['kw']['kw_state'] = $this->input['kw_state'];
		if(strlen($this->input['kw_title']))
			$pvar['kw']['kw_title'] = $this->input['kw_title'];
		if(strlen($this->input['kw_editor']))
			$pvar['kw']['kw_editor'] = $this->input['kw_editor'];
		if(plugin('is_date',$this->input['kw_start_time']))
			$pvar['kw']['kw_start_time'] = $this->input['kw_start_time'];
		if(plugin('is_date',$this->input['kw_end_time']))
			$pvar['kw']['kw_end_time'] = $this->input['kw_end_time'];

		$sqlWhere = " where 1";
		$sqlWhere .= strlen($pvar['kw']['kw_state']) ? " and i.state = {$pvar['kw']['kw_state']}" : '';
		$sqlWhere .= $pvar['kw']['kw_title'] ? " and i.title like('%{$pvar['kw']['kw_title']}%')" : '';
		$sqlWhere .= $pvar['kw']['kw_editor'] ? " and u.username like('%".$pvar['kw']['kw_editor']."%')" : '';
		$sqlWhere .= $pvar['kw']['kw_start_time'] ?	" and i.put_time > ".plugin('unixtime',$pvar['kw']['kw_start_time'],'0:0:0') : '';
		$sqlWhere .= $pvar['kw']['kw_end_time'] ? " and i.put_time <= ".plugin('unixtime',$pvar['kw']['kw_end_time'],'23:59:59') : '';
		
		$sqlOrder = " order by i.id desc";
		$sql = "select i.id as id, i.state as state, i.title as title, i.link as link, i.put_time as put_time, u.username as editor from "
			.$this->tab." i left join ".TB_PREFIX."sys_user u on i.editor=u.id";
		
		$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		if(!$rs->RecordCount() && $this->currentPage !=0){
			//将第一页的记录显示出来
			$this->currentPage = 0;
			$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		}
		while(!$rs->EOF){
			$rs->fields['state'] = $rs->fields['state']?'<img src="imgs/icon/check.gif" title="已发布">':'<img src="imgs/icon/uncheck.gif" title="未发布">';
			$rs->fields['put_time'] = date(DATE_FORMAT,$rs->fields['put_time']);
			$rs->fields['pub_time'] = date(DATE_FORMAT,$rs->fields['pub_time']);
			$rs->fields['btns'] = $this->btnUpdate($rs->fields['id'])
					.$this->btnDel($rs->fields['id']);
			
			$pvar['list'][]=$rs->fields;
			$rs->MoveNext();
		}
		
		$this->sess->setQueryData($pvar['kw']);
		
		if ($rs->RecordCount()) {
			$totalRecord = $this->db->GetOne("select count(*) as total from $this->tab i $sqlWhere");
			//$totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
			$pvar['page_index'] = pageIndex(Core::getUrl('','','',true), $totalRecord, $this->currentPage, $this->row);
		}
		$pvar['title'] = '友情链接列表';
		$pvar['form_act'] = Core::getUrl('','','',true);
		$pvar['cate_sel'] = Category::selector(CATE_INFO,'kw_cate',$pvar['kw']['kw_cate'],false,'',false);
		$pvar['state'] = Form::select('kw_state',array(''=>'', '1'=>'已发布', '0'=>'未发布'),$pvar['kw']['kw_state']);
		$pvar['mul_op'] = $this->btnMop();
		$pvar['button'] = $this->btnPublish();
		
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
	function btnPublish(){
		$url = Core::getUrl('publish');
		return " <input type='button' onclick=\"location.replace('{$url}');\" value='发布新资讯' />";
	}
	function btnUpdate($id){
		$url = Core::getUrl('update','',array('id'=>$id));
		return "<a href=\"$url\">修改</a>";
	}
	function btnDel($id){
		$msg = '你确定要删除吗？';
		$url = Core::getUrl('delete','',array('id'=>$id));
		return " <a href=\"javascript:if(confirm('{$msg}'))location.replace('{$url}');\"> 删除</a>";
	}
	function btnPreview($id){
		$url = Core::getUrl('preview','',array('id'=>$id));
		return " <a href='$url' target='_blank'>预览</a>";
	}
	function btnMop(){
		$f = "";
		$options = "<option value=''>...</option>\n"
					."<option value='Public'>发布</option>\n"
					."<option value='Disable'>不发布</option>\n"
					."<option value='' disabled='disabled'>------</option>\n"
					."<option value='Del'>删除</option>\n";
		$js_code = "
		<script language='javascript'>
		var f = document.getElementById('main_form');
		function mulop(act){
			if('Public' == act){
				if(confirm('你确定要发布所有的选中项吗？')){
					f.action='".Core::getUrl('state','',array('val'=>1),true)."';
					f.submit();
				}
			}
			if('Disable' == act){
				if(confirm('你确定要不发布所有的选中项吗？')){
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
