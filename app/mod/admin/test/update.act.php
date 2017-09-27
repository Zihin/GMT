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
	var $tab = 'test';
	
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

		if(is_array($data['grade'])){
			foreach($data['grade'] as $key => $val){
				$temp[$val] = $data['price'][$key];
			}
			unset($data['grade']);
		}
		$data['grade'] = serialize($temp);

		$sql = "select * from ".$this->tab." where id=$id";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs,$data);
		return $this->db->Execute($sql);
	}
	function showForm($data,$eMsg=null){

                $data['center'] = Category::selector_c(3,'item[center]','center',$data['center'],true,'',false);
		if(!is_array($data['grade'])) {
			$grade = unserialize($data['grade']);
			unset($data['grade']);
			if (is_array($grade)) {
				foreach ($grade as $key => $val) {
					$data['grade'][] = $key;
					$data['price'][] = $val;
				}
			}
		}
		$pvar['title'] = '修改考试信息';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('showlist');
		
		$this->addTplFile('form');
		$this->assign($pvar);
		$this->display();
	}

	function isExists($test_name , $id){
		return $this->db->GetOne("select count(*) from $this->tab where test_name='$test_name' and id<>$id");
	}
	function validate($data){
		$eMsg = array();
		     if(empty($data['test_name'])){
                    $eMsg['test_name'] = '考试名称不能为空';
		}else if($this->isExists($data['test_name'],$data['id'])){
                    $eMsg['test_name'] = '考试名称已经存在了,不能重复发布';
                }
		if($data['subject']){
                    if(strlen($data['subject']) > 30){
                        $eMsg['subject'] = '科目名称的长度不能大于30个字符';
                    }
		}else{
			$eMsg['subject'] = '科目名称不能为空';
		}

		if(empty($data['exam_time'])){
			$eMsg['exam_time'] = '考试时间段用不能为空';
		}
		if(is_array($data['grade'])){
			foreach($data['grade'] as $key => $val){
				if(!empty($val)){
					if(empty($data['price'][$key])){
						$eMsg['grade'] = '级别对应的价格不能为空';
						break;
					}
				}else{
					$eMsg['grade'] = '级别不能为空';
					break;
				}
			}
		}


		return renderMsg($eMsg);
	}
}
?>
