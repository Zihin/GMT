<?php
/***************************************************************
 * 修改产品内容
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/selector.php';
include_once LIB_DIR.'/common/category.php';

class Update extends Page{
	var $db;
	var $tab = 'product';
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$this->input = trimArr($this->input);
		$data = stripQuotes($this->input['item']);
		$id = $this->input['id']?$this->input['id']: $data['id'];
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
			removeCache('product','view',$id);	//清除缓存文件
		}
		
		Core::redirect(Core::getUrl('showlist','','',true));
	}
	
	function getData($id){
		$sql = "select * from ".$this->tab." where id=$id";
		$data = $this->db->GetRow($sql);
		return $data;
	}
	
	function updateDb($id,$data){
		unset($data['id']);	//防止ID号被修改
		$sql = "select * from ".$this->tab." where id=$id";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs,$data);
		return $this->db->Execute($sql);
	}
	function isExists($sn, $id){
		return $this->db->GetOne("select count(*) from $this->tab where sn='$sn' and id<>$id");
	}
	function showForm($data,$eMsg=null){
		$data['new'] = Form::yn('item[new]',$data['new']);
		$data['cate'] = Category::selector(CATE_PD,'item[cate]',$data['cate'],true,'',false);
		$data['preview'] = plugin('loadmedia', $data['pic'], 120, 120);
		
		$pvar['title'] = '修改产品资料';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('showlist');
		
		$this->addTplFile('form');
		$this->assign($pvar);
		$this->display();
	}

	function validate($data){
		$eMsg = array();
		if($data['sn']){
			if(strlen($data['sn']) > 30){
				$eMsg['sn'] = '款号的长度不能大于30个字符';
			}else if($this->isExists($data['sn'], $data['id'])){
				$eMsg['sn'] = '产品库中已经存在有相同款号的产品了,不能重复发布';
			}
		}else{
			$eMsg['sn'] = '款号不能为空';
		}
		/*
		if(!is_numeric($data['price'])){
			$eMsg['price'] = '请正确填写产品的售价';
		}
		if(!strlen($data['intro'])){
			$eMsg['intro'] = '介绍内容不能为空';
		}
		 */
		if(!strlen($data['pic'])){
			$eMsg['pic'] = '请为上传产品图片';
		}
		if(!is_numeric($data['cate'])){
			$eMsg['cate'] = '请选择要发布到的类别';
		}if($data['cate']){
			$recordNum = $this->db->getOne("select count(*) from $this->tab where cate={$data['cate']}");
			$maxNum = Category::getMax($data['cate']);
			if($maxNum && $maxNum <= $recordNum){
				$eMsg['cate'] = "该类别最多只能发布 {$maxNum} 条信息,目前已经达到了最大值,所以当前的信息无法发布";
			}
		}
		return renderMsg($eMsg);
	}
}
?>
