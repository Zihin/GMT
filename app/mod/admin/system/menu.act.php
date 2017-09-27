<?php
/***************************************************************
 * 系统菜单编辑模块
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

include_once LIB_DIR.'/common/treenode.class.php';

class Menu extends Page{
	var $db;
	var $menu;
	var $tab = 'sys_menu';
	
	function __construct(){
		parent::__construct();
		$this->tab = TB_PREFIX.$this->tab;
		
		$this->db = Core::getDb();
		//实例化一个树型节点操作类
		$this->node = new Treenode($this->tab,$this->db);
		//$this->db->debug = true;
	}
	function process(){
		switch($this->input['action']){
			case 'add':{
				$this->add();
			}
			break;
			case 'update':{
				$this->update();
			}
			break;
			case 'del':{
				$this->del();
			}
			break;
			case 'move':{
				$this->move();
			}
			break;
			case 'remount':{
				$this->remount();
			}
			break;
			default:{
				$this->listNode();
			}
		}
	}
	function listNode(){
		include_once LIB_DIR.'/common/formelem.php';
		$pvar['kw']['kw_pid'] = is_numeric($this->input['kw_pid']) ? $this->input['kw_pid'] : 1;
		$pvar['kw']['kw_expan'] = $this->input['kw_expan'] ? (int)$this->input['kw_expan'] : 0;
		$this->sess->setQueryData($pvar['kw']);
		
		$sql = $pvar['kw']['kw_expan']
			? "select m1.id as id, m1.title as title, m1.lev as lev, m1.child_num as child_num, m1.description as description from ".$this->tab." m1,".$this->tab." m2 where m1.lft > m2.lft and m1.lft < m2.rgt and m2.id=".$pvar['kw']['kw_pid']." and m1.id <>1 and m1.id <> {$pvar['kw']['kw_pid']} order by m1.lft"
			: "select * from ".$this->tab." where pid={$pvar['kw']['kw_pid']} order by lft, id";
			
		$baseLev = 1 + $this->db->GetOne("select lev from ".$this->tab." where id = ".$pvar['kw']['kw_pid']);
		$rs = $this->db->Execute($sql);
		$list = array();
		while(!$rs->EOF){
			$rs->fields['title'] = $rs->fields['child_num']
					? '<a href="'.Core::getUrl('','',array('kw_pid'=>$rs->fields['id']),true).'">'.$rs->fields['title'].'</a>'
					: $rs->fields['title'];
			if($pvar['kw']['kw_expan']){
				$levOffset = $rs->fields['lev'] - $baseLev;
				$preIcon = $rs->fields['child_num']? '<img src="imgs/icon/arrow.gif"> ' : '|--'; 
				$rs->fields['title'] = $levOffset
					? str_repeat('<span style="color:#ddd">|&nbsp;&nbsp;</span>',$levOffset).$preIcon.$rs->fields['title']
					: '<img src="imgs/icon/arrow.gif"> '.$rs->fields['title'];
			}else{
				$rs->fields['title'] = '<img src="imgs/icon/arrow.gif"> '.$rs->fields['title'];
			}
			$rs->fields['btns'] = $this->btnRemount($rs->fields['id'])
				.$this->btnMoveUp($rs->fields['id'])
				.$this->btnMoveDown($rs->fields['id'])
				.$this->btnAdd($rs->fields['id'])
				.$this->btnUpdate($rs->fields['id'])
				.$this->btnDel($rs->fields['id']);
			$pvar['list'][] = $rs->fields;
			
			$rs->MoveNext();
		}
		
		$pvar['title'] = '系统菜单';
		$pvar['btns'] = $this->btnAddNode(1,'添加主菜单').$this->btnAddNode($pvar['kw']['kw_pid'],'在当前位置添加菜单');
		$pvar['form_act'] = Core::getUrl('','','',true);
		$pvar['nodepath'] = $this->getPath($pvar['kw']['kw_pid'],true);
		$label = $pvar['kw']['kw_expan'] ? '折叠子菜单' : '展开子菜单';
		$pvar['btns'] .= " <input type='submit' value='$label' onclick=\"document.getElementById('kw_expan').value = !(document.getElementById('kw_expan').value-0)-0;\">";
		
		$this->addTplFile('menu_list');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	/**
	 * 添加一个菜单
	 */
	function add(){
		$pid = $this->input['pid'] ? $this->input['pid'] : $this->input['item']['pid'];
		if(!is_numeric($pid)){
			Core::raiseMsg('错误!没有指定父菜单');
		}
		$data = $this->input['item'];
		$data['pid'] = $pid;
		if(empty($this->input['submit'])){
			$this->showForm($this->input['action'],$data);
			return;
		}
		if($emsg = $this->validate($data)){
			$this->showForm($this->input['action'],$data,$emsg);
			return;
		}
		$sql = "select max(id) from ".$this->tab;
		$data['id'] = $this->db->GetOne($sql) + 1;
		$this->node->addChild($data);
		$pid = $this->db->GetOne("select pid from ".$this->tab." where id=$pid");
		$pid = $data['pid'] ? $data['pid'] : 1;
		Core::redirect(Core::getUrl('','',array('kw_pid'=>$pid),true));
	}
	
	/**
	 * 删除一个菜单和它的子菜单
	 */
	function del(){
		if (!is_numeric($this->input['id'])) {
			Core::raiseMsg('错误! 没有选定任何的待删除项!');
		}
		$this->node->delNode($this->input['id']);
		Core::redirect(Core::getUrl('','','',true));
	}
	function update(){
		$data = $this->input['item'];
		if(!is_numeric($this->input['id'])){
			Core::raiseMsg('错误!没有指定待修改项的ID号');
		}
		if(empty($this->input['submit'])){
			$data = $this->getNodeInfo($this->input['id']);
			$this->showForm($this->input['action'],$data);
			return;
		}
		if($emsg = $this->validate($data)){
			$this->showForm($this->input['action'],$data,$emsg);
			return;
		}
		
		$sql = "select * from ".$this->tab." where id = {$this->input['id']}";
		$rs = $this->db->Execute($sql);
		$sql = $this->db->GetUpdateSQL($rs,$data);
		$this->db->Execute($sql);
		
		Core::redirect(Core::getUrl('','','',true));
	}
	function move(){
		$direction = $this->input['dir'];
		if (!strlen($this->input['id'])) {
			Core::raiseMsg('错误! 没有指定菜单ID号!');
		}
		if(('up' == $direction) || ('down' == $direction)){
			$this->node->moveNode($this->input['id'], $direction);
		}
		else Core::raiseMsg('错误!方向参数不正确,无法执行移动菜单位置的操作...');
		Core::redirect(Core::getUrl('','','',true));
	}
	function remount(){
		if(!is_numeric($this->input['id']) || !is_numeric($this->input['pid'])){
			Core::raiseMsg('错误!参数不正确!');
		}
		$this->node->remountNode($this->input['id'],$this->input['pid']);
		Core::redirect(Core::getUrl('','','',true));
	}
	function showForm($action,$data,$emsg = null){
		if(is_numeric($data['pid'])){
			$pvar['path'] = $this->getPath($data['pid']);
		}
		if('add' == $action){
			$pvar['title'] = '添加菜单';
			$pvar['form_act'] = Core::getUrl('','',array('action'=>'add'));
		}else {
			$pvar['title'] = '编辑菜单';
			$pvar['form_act'] = Core::getUrl('','',array('action'=>'update','id'=>$data['id']));
			
		}
		$pvar['item'] = $data;
		$pvar['emsg'] = $emsg;
		$pvar['goback'] = Core::getUrl('','','',true); 
		
		$this->addTplFile('menu_form');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	function validate($data){
		$emsg = array();
		if(!strlen($data['title'])){
			$emsg['title'] = '标题不能为空';
		}
		return renderMsg($emsg);
	}
	function getNodeInfo($id){
		$sql = "select * from ".$this->tab." where id = $id";
		return $this->db->GetRow($sql);
	}
	function getPath($id,$addLink = false) {
		$path = '';
		$sql = "select c2.id as id, c2.title as title from ".$this->tab." c1,".$this->tab." c2 where c1.lft between c2.lft and c2.rgt and c1.id=$id order by c2.lft asc";
		$rs = $this->db->Execute($sql);
		while ($rs && !$rs->EOF) {
			$path .= $addLink 
					? "<a href='".Core::getUrl('','',array('kw_pid'=>$rs->fields['id']),true)."'>".$rs->fields['title'].'</a> >> '
					: $rs->fields['title'].' >> ';
			$rs->MoveNext();
		}
		return substr($path,0,-4);
	}
	function btnAddNode($pid,$label){
		$url = Core::getUrl('','',array('action'=>'add','pid'=>$pid));
		return " <input type='button' onclick=\"location.replace('{$url}');\" value='$label' />";
	}
	function btnAdd($pid){
		$url = Core::getUrl('','',array('action'=>'add','pid'=>$pid));
		return " <a href='$url'><img src='imgs/icon/ins.gif' title='增加子菜单' alt='' align='absmiddle' border='0' /></a>";
	}
	function btnDel($id){
		$msg = '在执行此操作时会把当前菜单的所有子菜单同时删除,你确定要删除吗？';
		$url = Core::getUrl('','',array('action'=>'del','id'=>$id));
		return " <a href=\"javascript:if(confirm('{$msg}'))location.replace('{$url}');\"><img src='imgs/icon/del.gif' title='删除' alt='' align='absmiddle' border='0' /></a>";
	}
	function btnUpdate($id){
		$url = Core::getUrl('','',array('action'=>'update','id'=>$id));
		return " <a href='$url'><img src='imgs/icon/info.gif' title='修改' alt='' align='absmiddle' border='0' /></a>";
	}
	function btnRemount($id){
		$msg = "你正在操作ID号为‘".$id."’的菜单,请输入你要挂接到的菜单ID号:";
		$url = Core::getUrl('','',array('action'=>'remount','id'=>$id));
		return " <a href=\"javascript:if(n = prompt('{$msg}'))location.replace('{$url}'+',pid,'+n);\"><img src='imgs/icon/tree.gif' title='改变父菜单' alt='' align='absmiddle' border='0' /></a>";
	}
	function btnMoveUp($id){
		$url = Core::getUrl('','',array('action'=>'move','id'=>$id,'dir'=>'up'));
		return " <a href='$url'><img src='imgs/icon/m_up.gif' title='上移' alt='' align='absmiddle' border='0' /></a>";
	}
	function btnMoveDown($id){
		$url = Core::getUrl('','',array('action'=>'move','id'=>$id,'dir'=>'down'));
		return " <a href='$url'><img src='imgs/icon/m_down.gif' title='下移' alt='' align='absmiddle' border='0' /></a>";
	}
}
?>
