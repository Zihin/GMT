<?php
/***************************************************************
 * 修改个人帐号资料
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/formelem.php';

class ChangePasswd extends Page{
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
			$data['username'] = $this->sess->get('username');
			$data['group'] = $this->sess->get('groupname');
			$this->showForm($data);
			return;
		}
		if($eMsg = $this->validate($data)){
			$this->showForm($data,$eMsg);
			return;
		}
		$this->update($id,$data);
		
		Core::raiseMsg('你的密码已经修改,请牢记你新设的密码...',array('确定'=>Core::getUrl('index')));
	}
	
	/**
	 * 检查原密码
	 */
	function checkPasswd($passwd){
		$sql = "select count(*) from ".$this->tab." where id=".$this->sess->getUserId()." and passwd = '".md5($passwd)."'";
		return $this->db->GetOne($sql);
	}
	
	/**
	 * 更新数据库中的指定记录
	 * @param int $id 帐号的ID号
	 * @param array $data 帐号的信息
	 */
	function update($id,$data){
		$data['passwd'] = md5($data['passwd']);
		$sql = "select passwd from ".$this->tab." where id=$id";
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
		$pvar['title'] = '修改密码';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('index');
		
		$this->addTplFile('changepasswd');
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
		if(!$data['old_passwd']){
			$eMsg['old_passwd'] = '请输入原来的密码';
		}else if(!$this->checkpasswd($data['old_passwd'])){
			$eMsg['old_passwd'] = '原密码输入不正确';
		}
		if(!$data['passwd']){
			$eMsg['passwd'] = '输入新密码';
		}else if($data['passwd'] != $data['passwd1']){
			$eMsg['passwd1'] = '两次输入的密码不一致,请重新输入';
		}
		return renderMsg($eMsg);
	}
}
?>
