<?php
/***************************************************************
 * 会员登录操作
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class Login extends Page{
	var $AuthLevel = ACT_OPEN;
	var $db;
	var $reset = 0;
	/**
	 * 构造函数
	 */
	function __construct(){
		parent::__construct();
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}

	/**
	 * 执行入口
	 * 
	 */
	function process(){
		$this->input = trimArr($this->input);
		if(!isset($this->input['submit'])){	//用户是否点击了"提交"?
			$this->showForm($this->input);
			return;
		}
		$eMsg = $this->checkInput($this->input);
		if(count($eMsg)){	//如果输入错误则重新显示操作界面
			$this->showForm($this->input,$eMsg);
			return;
		}
		$userinfo = $this->getUserInfo($this->input['username']);
		if($eMsg = $this->validate($userinfo)){
			$this->showForm($this->input,$eMsg);
			return;
		}
		
		$this->sess->set('username',$userinfo['username']);
		$gInfo = $this->db->GetRow("select title,discount from ".TB_PREFIX."mb_group where id={$userinfo['gid']}");
		$this->sess->set('groupname',$gInfo['title']);
		$this->sess->set('discount',$gInfo['discount']);
		
		$this->sess->setUserId($userinfo['id']);
		$this->sess->setGroupId($userinfo['gid']);
		
		//跳转页面
		Core::redirect(Core::getUrl('memberinfo','member', array('lang'=>LANGUAGE)));
	}
	
	/**
	 * 显示登录页面
	 */
	function showForm($data,$eMsg=null){
		$pvar['username'] = $data['username'];
		$pvar['form_act'] = Core::getUrl('login');
		$pvar['emsg'] = $eMsg;
		if(GD_ENABLE) $pvar['login_times'] = $this->sess->get('login_times');

		$pvar['dyncode_img'] = Core::getUrl('dyncodeImg','default');

		$this->addTplFile('login');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	
	/**
	 * 检查输入数据的完整性
	 * @param array $data 用户输入的数据
	 * @return array $eMsg 错误信息字符串
	 */
	function checkInput(& $data){
		$eMsg = array();
		if($data['isdycode'] == 1) {
			if (GD_ENABLE && strtolower($data['dyncode']) != strtolower($this->sess->get('dyncode'))) {
				$eMsg['dyncode'] = '你输入的动态码不正确';
			}
		}
		if(!$data['username']){
			$eMsg['username'] = '请输入用户名';
		}
		if(!$data['password']){
			$eMsg['password'] = '请输入密码';
		}
		return renderMsg($eMsg);
	}
	
	function validate($userinfo){
		if(GD_ENABLE) $this->sess->set('login_times',$this->sess->get('login_times')+1);//增加尝试登录的次数
		if(!count($userinfo) || $userinfo['passwd'] != md5($this->input['password'])){
			$eMsg['msg'] = renderMsg('你的用户名和密码不匹配');
			return $eMsg;
		}
		if(!$userinfo['actived']){
			$eMsg['msg'] = renderMsg('你的帐号处于未激活状态,暂时不能登录...');
			return $eMsg;
		}
		$sql = "select count(*) from ".TB_PREFIX."mb_group where id=".(int)$userinfo['gid'];
		if(!$this->db->getOne($sql)){
			$eMsg['msg'] = renderMsg('你所属的用户组不存在,无法为你分配权限,请与管理员联系!');
			return $eMsg;
		}
		if(GD_ENABLE) $this->sess->set('login_times');	//清空尝试登录的次数
		return;
	}
	
	/**
	 * 从数据库读取用户资料
	 * @param string $username 用户名
	 * @return array
	 */
	function getUserInfo($usernmae){
		$sql = "select * from ".TB_PREFIX."member where username = '$usernmae'";
		return $this->db->GetRow($sql);
	}
}
?>
