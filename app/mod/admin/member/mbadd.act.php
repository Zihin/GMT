<?php
/***************************************************************
 * 增加会员
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/formelem.php';
include_once 'member.lib.php';

class MbAdd extends Page{
	var $AuthLevel = ACT_NEED_AUTH;
	var $db;
	var $tab = "member";
	
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
		Core::redirect(Core::getUrl('mblist'));
	}
	
	/**
	 * 检查会员名是否存在
	 * @param string $username 会员名
	 * @return int 存在的量 
	 */
	function isExist($username){
		$sql = "select count(*) from ".$this->tab." where username='$username'";
		return $this->db->GetOne($sql);
	}
	
	/**
	 * 往数据库插入一条会员帐号资料
	 * @param array $data 帐号资料
	 */
	function insert($data){
		unset($data['id']);
		$data['reg_date'] = time();
		$data['member_code'] = 'GMT'.date('Ymd').plugin('rand_string',4,'0123456789');
		$data['passwd'] = md5($data['passwd']);
		$data['reg_ip'] = clientIp();
		
		$sql = "select * from ".$this->tab." where id=-1";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetInsertSQL($rs,$data);
		return $this->db->Execute($sql);
	}
	
	/**
	 * 检查输入数据的完整性
	 * @param array $data 会员输入的数据
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
			$eMsg['actived'] = '请确定该会员帐号是否马上激活';
		}
		if(strlen($data['email']) && !plugin('is_email',$data['email'])){
			$eMsg['email'] = '你的输入的email的格式不正确';
		}

//		if(!$data['area']){
//			$eMsg['area'] = '请选择该会员所在地区区域';
//		}
		if(!is_numeric($data['gid'])){
			$eMsg['gid'] = '请选择该会员所属的会员组';
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
		$data['sex'] = Form::sex('item[sex]',$data['sex']);
		$data['gid'] = groupSelect('item[gid]',$data['gid']);
		//$data['area'] = plugin('areaselector', 'item[area]', $data['area']);
		
		$pvar['title'] = '开通新的会员帐号';
		$pvar['form_act'] = Core::getUrl();
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('mblist','','',true);
		
		$this->addTplFile('mb_form');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
}
?>
