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
	var $tab = "test";
	
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

		$sqlWhere = " where 1";
		
		$sqlOrder = " order by id desc";
		$sql = "select * from "
			.$this->tab."";
		
		$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		if(!$rs->RecordCount() && $this->currentPage !=0){
			//将第一页的记录显示出来
			$this->currentPage = 0;
			$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
		}
		while(!$rs->EOF){
			$rs->fields['state'] = $rs->fields['state']?'<img src="imgs/icon/check.gif" title="已发布">':'<img src="imgs/icon/uncheck.gif" title="未发布">';

			$rs->fields['put_time'] = date(DATE_FORMAT,$rs->fields['put_time']);
			$rs->fields['exam_time'] = explode('#',$rs->fields['exam_time']);
                        if($rs->fields['center']){
                            $cate = Category::getData($rs->fields['center']);
                            $rs->fields['center'] = $cate['title_zh'];
                        }
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
		$pvar['title'] = '查看考试信息列表';
		$pvar['form_act'] = Core::getUrl('','','',true);
		$pvar['cate_sel'] = Category::selector(CATE_PD,'kw_cate',$pvar['kw']['kw_cate'],false,'',false);
		$pvar['state'] = Form::select('kw_state',array(''=>'','1'=>'已发布','0'=>'未发布'),$pvar['kw']['kw_state']);
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
		return " <input type='button' onclick=\"location.replace('{$url}');\" value='发布考试信息' />";
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
