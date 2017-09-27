<?php
/***************************************************************
 * 修改个人资料
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/pager.php';
include_once LIB_DIR.'/common/formelem.php';

class MemberInfo extends Page{
	var $AuthLevel = ACT_NEED_LOGIN;
	var $db;
	var $tab = "member";
	var $row = 12;		//每页显示的文章条数
	var $cPage;
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		$this->uid = $this->sess->getUserId();
		
		$this->db = Core::getDb();
		//$this->db->debug = true;
	}
	function process(){
		$data = trimArr($this->input['item']);
		if(empty($this->input['submit'])){
			$eMsg['passwd'] = '密码已隐藏,如果不想修改密码则将此处留空';
			$this->showForm($data,$eMsg);
			return;
		}

		if($eMsg = $this->validate($data)){
			$eMsg['passwd'] = '密码已隐藏,如果不想修改密码则将此处留空';
			$this->showForm($data,$eMsg);
			return;
		}
		$this->update($data);
		Core::raiseMsg('修改成功!',array('确定'=>Core::getUrl()));
	}
	
	/**
	 * 读取待修改记录的数据
	 */
	function getData(){
		$sql = "select * from ".$this->tab." where id=$this->uid";
		$data = $this->db->GetRow($sql);
		$data['gid'] = $this->sess->get('groupname');
		$data['reg_date'] = date('Y-m-d',$data['reg_date']);
		$data['discount'] = ($this->sess->get('discount') * 100)."%";
		return $data;
	}
	
	/**
	 * 更新数据库中的指定记录
	 * @param array $data 帐号的信息
	 */
	function update($data){
		unset($data['id']);		//防止ID号被修改
		unset($data['gid']);	//防止帐号类型被修改
		unset($data['username']); //防止用户名被修改
		
		if(isset($data['passwd'])) $data['passwd'] = md5($data['passwd']);
		$sql = "select * from ".$this->tab." where id=$this->uid";
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
		$pvar['form_act'] = Core::getUrl();
		$pvar['memberinfo'] = $this->getData();
		$sex = empty($data['sex']) ? $pvar['memberinfo']['sex'] : $data['sex'];
		$data['sex'] = Form::sex('item[sex]',$sex);
		$pvar['item'] = $data;
		$pvar['emsg'] = $eMsg;
		$pvar['goback'] = Core::getUrl('index','default');
		/**
		 * 考生信息列表
		 */
		$sqlWhere = " where mid=$this->uid and is_pay = 1";

		$sqlOrder = " order by id desc";
		$sql = "select * from ".TB_PREFIX."candidate_test";
		$rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->cPage);
		while(!$rs->EOF){
			$pvar['list'][] = $rs->fields;
			$rs->MoveNext();
		}
		$this->sess->setQueryData($pvar['kw']);
		if($rs->RecordCount()){
			$totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|Ui', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
			$pvar['page_index'] = pageIndex(Core::getUrl('',''),$totalRecord,$this->cPage,$this->row);
		}

		$pvar['self_id'] = 'memberinfo';
		$pvar['nav_id'] = 'member';
		$this->addTplFile('memberinfo');
		$this->assign(stripQuotes($pvar));
		$this->display($pvar);
	}
	
	/**
	 * 检查会员输入的数据是否有效和自动补充额外数据
	 * @param array $data 会员输入的数据
	 * @return array $eMsg 错误信息
	 */
	function validate(& $data){
		$eMsg = array();
		if(strlen($data['passwd'])<=0){
			unset($data['passwd']);
		}//防止密码被清空
//		if(strlen($data['email']) && !plugin('is_email',$data['email'])){
//			$eMsg['email'] = '你的输入的email的格式不正确';
//		}
		if(!$data['name']){
			$eMsg['name'] = '请输入你的真实姓名';
		}

		if(!$data['mobile']){
			$eMsg['mobile'] = '请输入手机号码';
		}

		return renderMsg($eMsg);
	}
}
?>

