<?php
/***************************************************************
 * 修改用户帐号资料
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/formelem.php';
include_once LIB_DIR.'/common/selector.php';
include_once APPROOT.'/user.lib.php';

class UserModify extends Page{
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
		$data = $this->input['item'];
		$id = $this->input['id']? $this->input['id'] : $data['id'];
		if(!is_numeric($id)){
			Core::raiseMsg('错误没有指定待修改帐号的ID号');
		}
		$eMsg['passwd'] = '密码已隐藏,如果不想修改密码则将此处留空';
		if(empty($this->input['submit'])){
			$data = $this->getData($id);
			$this->showForm($data,$eMsg);
			return;
		}
		if($eMsg = $this->validate($data)){
			$this->showForm($data,$eMsg);
			return;
		}
		$this->update($id,$data);
		Core::redirect(Core::getUrl('userlist','','',true));
	}
	
	/**
	 * 读取待修改记录的数据
	 * @param int $id 记录的ID号
	 * @return array
	 */
	function getData($id){
		$sql = "select * from ".$this->tab." where id=$id";
		return $this->db->GetRow($sql);
	}
	
	/**
	 * 更新数据库中的指定记录
	 * @param int $id 帐号的ID号
	 * @param array $data 帐号的信息
	 */
	function update($id,$data){
		unset($data['id']);	//防止ID号被修改
		if(isset($data['passwd'])) $data['passwd'] = md5($data['passwd']);
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
		$data['actived'] = Form::yn('item[actived]',$data['actived']);
		$data['gid'] = groupSelect('item[gid]',$data['gid']);
		$pvar['title'] = '修改用户帐号资料';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('userlist','','',true);
		
		$this->addTplFile('user_form');
		$this->assign(stripQuotes($pvar));
		$this->display($pvar);
	}
	/**
	 * 检查登录名是否已经存在
	 * @param string $username 登录名
	 * @param int $me 自身的ID号
	 * @return bool
	 */
	function isExist($username, $me){
		$sql = "select count(*) from ".$this->tab
			." where username='$username' and id <>$me";
		if($this->db->GetOne($sql)){	
			return true;
		}
		return false;
	}
	
	/**
	 * 检查用户输入的数据是否有效和自动补充额外数据
	 * @param array $data 用户输入的数据
	 * @return array $eMsg 填写错误信息
	 */
	function validate(& $data){
		$eMsg = array();
		if(!strlen($data['username'])){
			$eMsg['username'] = '登录名不能为空';
		}else if($this->isExist($data['username'],$data['id'])){
			$eMsg['username'] = '登录名已经存在,请重新输入';
		}
		if(strlen($data['passwd'])){
			if($data['passwd'] != $data['passwd1']){
				$eMsg['passwd1'] = '你两次输入的密码不一不致';
			}
		}else unset($data['passwd']); //防止密码被清空
		if(!is_numeric($data['gid'])){
			$eMsg['gid'] = '请选择该用户所属的用户组';
		}
		if(strlen($data['email']) && !plugin('is_email',$data['email'])){
			$eMsg['email'] = '你的输入的email的格式不正确';
		}
		return renderMsg($eMsg);
	}
}
?>
