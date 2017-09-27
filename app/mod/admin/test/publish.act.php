<?php
/***************************************************************
 * 发布新产品
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/selector.php';
include_once LIB_DIR.'/common/category.php';

class Publish extends Page{
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
		if(!$this->input['submit']){
			$this->showForm($data);
			return;
		}
		if($eMsg = $this->validate($data)){
			$this->showform($data,$eMsg);
			return;
		}
		if(!$this->insert($data)){
			Core::raiseMsg('操作失败!,原因未知...');
		}
		Core::redirect(Core::getUrl('showlist'));
	}
	
	function insert($data){
		$data['editor'] = $this->sess->getUserId();
		if(is_array($data['grade'])){
			foreach($data['grade'] as $key => $val){
					$temp[$val] = $data['price'][$key];
			}
			unset($data['grade']);
		}
		$data['grade'] = serialize($temp);
		$data['put_time'] = time();
		unset($data['id']);
		$sql = "select * from ".$this->tab." where id=-1";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetInsertSQL($rs,$data);
		return $this->db->Execute($sql);
	}
	function isExists($test_name){
		return $this->db->GetOne("select count(*) from $this->tab where test_name='$test_name'");
	}
	function validate($data){
		$eMsg = array();
                if(empty($data['test_name'])){
                    $eMsg['test_name'] = '考试名称不能为空';
		}else if($this->isExists($data['test_name'])){
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
	function showForm($data,$eMsg=null){
                $data['center'] = Category::selector_c(3,'item[center]','center',$data['center'],true,'',false);
		$pvar['title'] = '发布考试信息';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('ShowList');
		
		$this->addTplFile('form');
		$this->assign($pvar);
		$this->display();
	}
}
?>
