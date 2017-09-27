<?php
/***************************************************************
 * 修改产品内容
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/selector.php';
include_once LIB_DIR.'/common/category.php';

class CandidateTestUpdate extends Page{
	var $db;
	var $tab = 'candidate_test';
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$this->input = trimArr($this->input);
		$data = stripQuotes($this->input['item']);
                $candidate_info = $this->input['candidate_info'];
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
		$data['stu_name'] = trim($candidate_info['sure_name']).trim($candidate_info['given_name']);
		$this->updateDb($id,$data);
                $cid=$candidate_info['id'];
		$this->updateCDb($cid,$candidate_info);
		
		if($this->db->Affected_Rows()){
			removeCache('candidate_test','CandidateTestUpdate',$id);	//清除缓存文件
		}
		
		Core::redirect(Core::getUrl('candidatetestupdate','',array('id'=>$id),false));
	}
	
	function getData($id){
		$sql = "select * from ".$this->tab." where id=$id";
		$data = $this->db->GetRow($sql);
		if($data['program']) {
			$data['program'] = unserialize($data['program']);
//			foreach($data['program'] as $key => $val){
//				if($val){
//					$data['program'][$key] = $val;
//				}else{
//					unset($data['program'][$key]);
//				}
//
//			}
		}
		return $data;
	}
	
	function updateDb($id,$data){
		unset($data['id']);	//防止ID号被修改   
                $data['program'] = serialize($data['program']);
		$sql = "select * from ".$this->tab." where id=$id";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs,$data);
		return $this->db->Execute($sql);
	}
        function updateCDb($id,$data){
                unset($data['id']);	//防止ID号被修改   
                $data['photo'] = str_replace('uploads/', '', $data['photo']);
                $data['passport_img1'] = str_replace('uploads/', '', $data['passport_img1']);
                $data['passport_img2'] = str_replace('uploads/', '', $data['passport_img2']);
		$sql = "select * from ".TB_PREFIX."candidate where id=$id";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs,$data);
		return $this->db->Execute($sql);
        }
	function isExists($sn, $id){
		return $this->db->GetOne("select count(*) from $this->tab where sn='$sn' and id<>$id");
	}
	function showForm($data,$eMsg=null){
                $candidate_info=$this->get_candidate_info($data['candidate_id']);
		$candidate_info['preview'] = plugin('loadmedia', 'uploads/'.$candidate_info['photo'], 120, 120);
		$candidate_info['preview2'] = plugin('loadmedia', 'uploads/'.$candidate_info['passport_img1'], 120, 120);
		$candidate_info['preview3'] = plugin('loadmedia', 'uploads/'.$candidate_info['passport_img2'], 120, 120);
                $gender = Form::sex('candidate_info[gender]',$candidate_info['gender']);
                $is_express = Form::radioyn('item[is_express]',$data['is_express']);
                $is_interpreter = Form::radioyn('item[is_interpreter]',$data['is_interpreter']);
		$pvar['title'] = '编辑考试信息';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['gender'] = $gender;
		$pvar['is_express'] = $is_express;
		$pvar['is_interpreter'] = $is_interpreter;
		$pvar['candidate_info'] = $candidate_info;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('showlist');

		$this->addTplFile('candidatetestupdate');
		$this->assign($pvar);
		$this->display();
	}

	function validate($data){
		$eMsg = array();
		return renderMsg($eMsg);
	}
	/**
	 * 获得考生信息
	 */
	function get_candidate_info($id){
		$sql = "select * from ".TB_PREFIX."candidate where id = '".$id."'";
		return $this->db->GetRow($sql);
	}
}
?>
