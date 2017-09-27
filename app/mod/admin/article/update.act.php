<?php
/***************************************************************
 * 修改资讯内容
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/formelem.php';
include_once LIB_DIR.'/common/category.php';

class Update extends Page{
	var $db;
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.'article';
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$this->input = trimArr($this->input);
		$data = stripQuotes($this->input['item']);
		$id = is_numeric($this->input['id'])? $this->input['id'] : $data['id'];
		if(!is_numeric($id)){
			Core::raiseMsg('错误!没有指定ID号');
		}
		if(empty($this->input['submit'])){
			$data = stripQuotes($this->getData($id));
			$this->showForm($data);
			return;
		}
		$data['id'] = $id;
		if($eMsg = $this->validate($data)){
			$this->showForm($data,$eMsg);
			return;
		}
		
		$this->updateDb($id,$data);
		
		if($this->db->Affected_Rows()){
			removeCache('info','detail',$id);	//清除缓存文件
		}
		
		Core::redirect(Core::getUrl('showlist','','',true));
	}
	
	function getData($id){
		$sql = "select * from ".$this->tab." where id=$id";
		$data = $this->db->GetRow($sql);
		$data['pub_time'] = date(DATE_FORMAT,$data['pub_time']);
		return $data;
	}
	
	function updateDb($id,$data){
		unset($data['id']);	//防止ID号被修改
		$sql = "select * from ".$this->tab." where id=$id";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs,$data);
		return $this->db->Execute($sql);
	}
	
	function showForm($data,$eMsg=null){
		$data['cate'] = Category::selector(CATE_INFO,'item[cate]',$data['cate'],true,'',false);
		$data['istop'] = Form::radio('item[istop]',array('0'=>'否', '1'=>'是'), $data['istop']);
		$data['preview'] = plugin('loadmedia', $data['pic'], 120, 120);
		
		$pvar['title'] = '编辑文章';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('showlist','','',true);
		
		$this->addTplFile('form');
		$this->assign($pvar);
		$this->display($pvar);
	}

	function isExist($title, $me){
		$sql = "select count(*) from ".$this->tab
			." where title='$title' and id <>$me";
		if($this->db->GetOne($sql)){	
			return true;
		}
		return false;
	}
	
	function validate($data){
		$eMsg = array();
		if(!$data['title']){
			$eMsg['title'] = '主题不能为空';
		}else if($this->isExist($data['title'],$data['id'])){
			$eMsg['title'] = '该主题已经存在,请重新填写';
		}
		if(!is_numeric($data['cate'])){
			$eMsg['cate'] = '请选择要发布到的类别';
		}
//		if(!strlen($data['lang'])){
//			$eMsg['lang'] = '请选择该文章的语言类型';
//		}
		if(!strlen($data['content'])){
			$eMsg['content'] = '内容不能为空';
		}
	
		if($data['cate']){
			$recordNum = $this->db->getOne("select count(*) from $this->tab where cate={$data['cate']} and id<>{$data['id']}");
			$maxNum = Category::getMax($data['cate']);
			if($maxNum && $maxNum <= $recordNum){
				echo $recordNum;
				$eMsg['cate'] = "该类别最多只能发布 {$maxNum} 条信息,目前已经达到了最大值,所以当前的信息无法转移到此类别";
			}
		}
		$eMsg = renderMsg($eMsg);
		return $eMsg;
	}
}
?>
