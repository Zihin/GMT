<?php
/***************************************************************
 * 增加后台用户
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/formelem.php';
include_once LIB_DIR.'/common/selector.php';
include_once APPROOT.'/user.lib.php';

class UserAdd extends Page{
	var $AuthLevel = ACT_NEED_AUTH;
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
		Core::redirect(Core::getUrl('userlist'));
	}
	
	/**
	 * 检查用户名是否存在
	 * @param string $username 用户名
	 * @return int 存在的量 
	 */
	function isExist($username){
		$sql = "select count(*) from ".$this->tab." where username='$username'";
		return $this->db->GetOne($sql);
	}
	
	/**
	 * 往数据库插入一条用户帐号资料
	 * @param array $data 帐号资料
	 */
	function insert($data){
		unset($data['id']);
		$data['reg_date'] = time();
		$data['passwd'] = md5($data['passwd']);
		$data['reg_ip'] = clientIp();
		
		$sql = "select * from ".$this->tab." where id=-1";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetInsertSQL($rs,$data);
		return $this->db->Execute($sql);
	}
	
	/**
	 * 检查输入数据的完整性
	 * @param array $data 用户输入的数据
	 * @return array $eMsg 错误信息字符串
	 */
	function validate($data){
		$eMsg = array();
		if(!$data['username']){
			$eMsg['username'] = '登录名不能为空';
		}else if($this->isExist($data['username'])){
			$eMsg['username'] = '该登录名已经存在,请重新输入';
		}
		if(!$data['passwd']){
			$eMsg['passwd'] = '密码不能为空';
		}else if($data['passwd'] != $data['passwd1']){
			$eMsg['passwd1'] = '你两次输入的密码不一不致';
		}
		if(!is_numeric($data['actived'])){
			$eMsg['actived'] = '请确定该用户帐号是否马上激活';
		}
		if(strlen($data['email']) && !plugin('is_email',$data['email'])){
			$eMsg['email'] = '你的输入的email的格式不正确';
		}
		if(!is_numeric($data['gid'])){
			$eMsg['gid'] = '请选择该用户所属的用户组';
		}
		return renderMsg($eMsg);
	}
	
	/**
	 * 显示操作页面
	 * @param array $data 预填数据
	 * @param array $eMsg 数据错误信息
	 */
	function showForm($data,$eMsg=null){
		$data['actived'] = Form::yn('item[actived]',$data['actived']);
		$data['gid'] = groupSelect('item[gid]',$data['gid']);
		
		$pvar['title'] = '开通新的用户帐号';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('userlist','','',true);
		
		$this->addTplFile('user_form');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
}
?>
