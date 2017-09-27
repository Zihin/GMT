<?php
/***************************************************************
 * 显示文章列表
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
 
include_once LIB_DIR.'/common/pager.php';
include_once LIB_DIR.'/common/category.php';
class ShowList extends Page{
	var $AuthLevel = ACT_OPEN;
	var $db;
	var $tab = 'article';
	var $row = 6;		//每页显示的文章条数
	var $cPage;
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		$this->cPage = $this->input['page'];
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$this->input = trimArr($this->input);
		$pvar = array();
		$pvar['kw']['cate'] = is_numeric($this->input['cate']) ? $this->input['cate'] : CATE_INFO;
		if($this->input['title'])
			$pvar['kw']['title'] = $this->input['title'];
		
		$sqlWhere = " where state=1 and lang='".LANGUAGE."' and cate in(".implode(',',Category::getAllChild($pvar['kw']['cate'])).")";
		$sqlWhere .= $pvar['kw']['title'] ? " and title like('%{$pvar['kw']['title']}%')" : '';
		
		$sqlOrder = " order by sort asc ,id desc";
		$sql = "select * from ".$this->tab;
		$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->cPage);
		while(!$rs->EOF){
			$rs->fields['put_time'] = date(DATE_FORMAT,$rs->fields['put_time']);
			$rs->fields['link'] = Core::getUrl('view','',array('id' => $rs->fields['id']));
                        $rs->fields['intro_content'] = utf8Cut(strip_tags($rs->fields['content']),60);
			$pvar['list'][] = $rs->fields;
			$rs->MoveNext();
		}
		$this->sess->setQueryData($pvar['kw']);
		if($rs->RecordCount()){
			$totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|Ui', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
			$pvar['page_index'] = pageIndex(Core::getUrl('','',array('cate'=>$pvar['kw']['cate'])),$totalRecord,$this->cPage,$this->row);
		}
		$cate = Category::getData($pvar['kw']['cate']);
		$pvar['cate_name'] = $cate['title_zh'];
		$pvar['cate_path'] = Category::getPath($pvar['kw']['cate'], Core::getUrl('','','',true), 3, ' > ');
        $pvar['self_id'] = 'article_'.$pvar['kw']['cate'];
		if($pvar['kw']['cate'] == 4) {
			$pvar['nav_id'] = 'gmt';
		}elseif($pvar['kw']['cate'] == 7){
			$pvar['nav_id'] = 'member';
		}elseif($pvar['kw']['cate'] == 5){
			$pvar['nav_id'] = 'news';
		}
		$this->addTplFile($cate['tpl_l'], true);
		$this->assign($pvar);
		$this->display();
	}
}
?>
