<?php
/***************************************************************
 * 修改个人帐号资料
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/formelem.php';

class MyInfo extends Page{
	var $AuthLevel = ACT_NEED_LOGIN;
	var $db;
	var $tab = "sys_user";
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$this->input = trimArr($this->input);
		$id = $this->sess->getUserId();
		$data = $this->input['item'];
		if(empty($this->input['submit'])){
			$data = $this->getData($id);
			$this->showForm($data);
			return;
		}
		if($eMsg = $this->validate($data)){
			$this->showForm($data,$eMsg);
			return;
		}
		$this->update($id,$data);
		Core::redirect(Core::getUrl('index'));
	}
	
	/**
	 * 读取待修改记录的数据
	 * @param int $id 记录的ID号
	 * @return array
	 */
	function getData($id){
		$sql = "select * from ".$this->tab." where id=$id";
		$data = $this->db->GetRow($sql);
		$data['gid'] = $this->sess->get('groupname');
		return $data;
	}
	
	/**
	 * 更新数据库中的指定记录
	 * @param int $id 帐号的ID号
	 * @param array $data 帐号的信息
	 */
	function update($id,$data){
		unset($data['id']);	//防止ID号被修改
		unset($data['username']);
		unset($data['active']);
		unset($data['gid']);
		
		$sql = "select * from ".$this->tab." where id=$id";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs,$data);
		return $this->db->Execute($sql);
	}
	
	/**
	 * 显示操作界面
	 * @param array $data 表单中预填的数据
	 * @param array $eMsg 填写错误信息
	 */
	function showForm($data,$eMsg=null){
		$pvar['title'] = '修改我的资料';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('index');
		
		$this->addTplFile('myinfo');
		$this->assign(stripQuotes($pvar));
		$this->display($pvar);
	}

	/**
	 * 检查用户输入的数据是否有效和自动补充额外数据
	 * @param array $data 用户输入的数据
	 * @return array $eMsg 填写错误信息
	 */
	function validate(& $data){
		$eMsg = array();
		if(strlen($data['email']) && !plugin('is_email',$data['email'])){
			$eMsg['email'] = '你的输入的email的格式不正确';
		}
		return renderMsg($eMsg);
	}
}
?>
