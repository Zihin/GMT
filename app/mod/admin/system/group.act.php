<?php

/***************************************************************
 * 用户组管理模块
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
include_once LIB_DIR.'/common/pager.php';

class Group extends Page {
	var $db;
	var $tab= "sys_group";

	function __construct() {
		parent :: __construct();
		$this->tab = TB_PREFIX.$this->tab;

		$this->db= Core :: getDb();
		//$this->db->debug = true;
	}
	function process() {
		switch ($this->input['act']) {
			case 'add' :
				{
					$this->add();
				}
				break;
			case 'update' :
				{
					$this->update();
				}
				break;
			case 'del' :
				{
					$this->del();
				}
				break;
			case 'perms' :
				{
					$this->permsSet();
				}
				break;
			default :
				{
					$this->showList();
				}
		}
	}
	function showList() {
		$this->input= trimArr($this->input);
		$currentPage= is_numeric($this->input['page']) ? $this->input['page'] : 0;
		$row= (is_numeric($this->input['row']) && $this->input['row'] <= 100) ? $this->input['row'] : 20;
		$sqlWhere= " where 1";
		if (strlen($this->input['kw_title'])) {
			$pvar['kw']['kw_title']= $this->input['kw_title'];
			$sqlWhere .= " and title like('%{$pvar['kw']['kw_title']}%')";
		}
		$sqlOrder= " order by id asc";
		$sql= "select * from ".$this->tab;
		$rs= $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder, $row, $row * $currentPage);
		if (!$rs->RecordCount() && $currentPage != 0) {
			//将第一页的记录显示出来
			$currentPage= 0;
			$rs= $this->db->SelectLimit($sql.$sqlWhere, $row, $row * $currentPage);
		}
		while (!$rs->EOF) {
			$rs->fields['btns']= $this->btnUpdate($rs->fields['id']).$this->btnPermsSet($rs->fields['id']).$this->btnDel($rs->fields['id']);
			$pvar['list'][]= $rs->fields;
			$rs->MoveNext();
		}
		$pvar['kw']['row']= $row;
		$pvar['kw']['page']= $currentPage;
		$this->sess->setQueryData($pvar['kw']);
		if ($rs->RecordCount()) {
			$totalRecord= $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
			$pvar['page_index']= pageIndex(Core :: getUrl('', '', '', true), $totalRecord, $currentPage, $row);
		}
		$pvar['title']= '用户组列表';
		$pvar['button']= $this->btnAdd();
		$pvar['form_act']= Core :: getUrl();
		$pvar['mul_op']= $this->btnMop();

		$this->addTplFile('group_list');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	function update() {
		$this->input= trimArr($this->input);
		if (!is_numeric($this->input['id'])) {
			Core :: raiseMsg('错误!没有指定待修改项的ID号');
		}
		$data= $this->input['item'];
		if (empty ($this->input['submit'])) {
			$data= $this->getGroupInfo($this->input['id']);
			$this->showForm($this->input['act'], $data);
			return;
		}
		if ($emsg= $this->validate($data)) {
			$this->showForm($this->input['act'], $data, $emsg);
			return;
		}
		$sql= "select * from ".$this->tab." where id=".$this->input['id'];
		$rs= $this->db->Execute($sql);
		$sql= $this->db->GetUpdateSQL($rs, $data);
		$this->db->Execute($sql);
		Core :: redirect(Core :: getUrl('', '', '', true));
	}
	function add() {
		$this->input= trimArr($this->input);
		$data= $this->input['item'];
		if (empty ($this->input['submit'])) {
			$this->showForm($this->input['act'], $data);
			return;
		}
		if ($emsg= $this->validate($data)) {
			$this->showForm($this->input['act'], $data, $emsg);
			return;
		}
		unset ($data['id']);
		$sql= "select * from ".$this->tab." where id = -1";
		$rs= $this->db->Execute($sql);
		$sql= $this->db->GetInsertSQL($rs, $data);
		if (!$this->db->Execute($sql)) {
			Core :: raiseMsg('操作失败,原因未知');
		}
		Core :: redirect(Core :: getUrl('', '', '', true));
	}
	function del() {
		$id= $this->input['id'];
		if (is_array($id)) {
			$id= implode(',', $id);
		} else
			if (!is_numeric($id)) {
				Core :: raiseMsg('错误! 没有选定任何的待删除项!');
			}

		$sql= 'delete from '.$this->tab." where id in($id)";
		$this->db->Execute($sql);
		Core :: redirect(Core :: getUrl('', '', '', true));
	}
	function permsSet() {
		if (!is_numeric($this->input['gid'])) {
			Core :: raiseMsg('错误!没有指定用户组ID号');
		}
		if (empty ($this->input['submit'])) {
			$this->showSettingForm($this->input['gid']);
			return;
		}
		$cacheFile = VAR_DIR.'/group_priv/'.DIR_PREFIX.'/gid_'.$this->input['gid'];
		removeFile($cacheFile);
		$priv = array();
		if (is_array($this->input['id'])) {
			foreach ($this->input['id'] as $v) {
				$priv[] = $v;
			}
			wfile($cacheFile, serialize($priv));
		}
		Core :: redirect(Core :: getUrl('', '', '', true));
	}
	function showSettingForm($gid) {
		$pvar['group']= $this->getGroupInfo($gid);
		$pvar['list']= $this->getAllPerms($gid);
		$pvar['title']= "设置用户组权限";
		$pvar['goback']= Core :: getUrl('', '', '', true);

		$this->addTplFile('group_perms');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	function getAllPerms($gid) {
		$cacheFile = VAR_DIR.'/group_priv/'.DIR_PREFIX.'/gid_'.$gid;
		$priv = unserialize(@file_get_contents($cacheFile));

		$sql= "select * from ".TB_PREFIX."sys_permissions order by title";
		$rs= $this->db->Execute($sql);
		while (!$rs->EOF) {
			$rs->fields['check']= is_array($priv) && array_search($rs->fields['title'], $priv) !== false ? 'checked=checked' : '';
			$list[]= $rs->fields;
			$rs->MoveNext();
		}
		return $list;
	}
	function getGroupInfo($id) {
		$sql= "select * from ".$this->tab." where id = $id";
		return $this->db->GetRow($sql);
	}
	function showForm($act, $data, $emsg= null) {
		$pvar= array ();
		if ('update' == $act) {
			$pvar['title']= '编辑用户组';
			$pvar['form_act']= Core :: getUrl('', '', array ('act' => 'update', 'id' => $data['id']));
		} else {
			$pvar['title']= '新建用户组';
			$pvar['form_act']= Core :: getUrl('', '', array ('act' => 'add'));
		}

		$pvar['item']= $data;
		$pvar['emsg']= $emsg;
		$pvar['goback']= Core :: getUrl('', '', '', true);

		$this->addTplFile('group_form');
		$this->assign(stripQuotes($pvar));
		$this->display();
	}
	function validate($data) {
		$emsg= array ();
		if (!$data['title']) {
			$emsg['title']= '用户组名不能为空';
		} else if ($this->isExist($data['title'], $data['id'])) {
			$emsg['title']= '用户组名已经存在,请重新输入';
		}
		return renderMsg($emsg);
	}
	function isExist($title, $me= null) {
		$sql= "select id from ".$this->tab." where title='$title'";
		$id= $this->db->GetOne($sql);
		if (!strlen($id))
			return false;
		else
			if ($me == $id)
				return false;
			else
				return true;
	}
	function btnAdd() {
		$url= Core :: getUrl('', '', array ('act' => 'add'));
		return " <input type='button' onclick=\"location.replace('{$url}');\" value='新建用户组' />";
	}
	function btnPermsSet($id) {
		$url= Core :: getUrl('', '', array ('act' => 'perms', 'gid' => $id));
		return " <a href='#' onclick=\"location.replace('$url');\">设置组权限</a>";
	}
	function btnUpdate($id) {
		return "<a href='#' onclick=\"location.replace('".Core :: getUrl('', '', array ('act' => 'update', 'id' => $id))."');\">修改</a>";
	}
	function btnDel($id) {
		$msg= '你确定要删除吗？';
		$url= Core :: getUrl('', '', array ('act' => 'del', 'id' => $id));
		return " <a href='#' onclick=\"if(confirm('{$msg}'))location.replace('{$url}');\">删除</a>";
	}
	function btnMop() {
		$msg= '注意!此操作不可恢复,你确定要删除吗？';
		$url= Core :: getUrl('', '', array ('act' => 'del'));
		return " <input type='button' onclick=\"if(confirm('{$msg}')){main_form.action='{$url}';main_form.submit();}\" value='删除' />";
	}
}
?>
