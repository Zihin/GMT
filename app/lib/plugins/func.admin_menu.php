<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 显示会员助手菜单
 * @param string $current 高亮显示当前菜单
 */
function func_admin_menu($current= null) {
	$menu= array (
			'首页' => '?default,index',
			'文章管理' => array (
				'文章列表' => '?article,showlist',
				'发布文章' => '?article,publish'
				),
			'机构和考点' => '?single,update,id,20',
			'奖学金' => '?single,update,id,21',
			'考试手册' => '?single,update,id,22',
			'考试信息' => array (
				'考试信息列表' => '?test,showlist',
				'发布考试信息' => '?test,publish',
				),
			'会员管理' => array (
				//'会员区公告' => '?member,notice',
				'查看会员列表' => '?member,mblist',
//				'快速注册新会员' => '?member,mbadd',
//				'会员分组' => array (
//					'会员组管理' => '?member,group',
//					//'新建会员组' => '?member,group,act,add'
//				)
			),
			'报名信息管理' => array(
				'报名信息列表' => '?signup,candidatetest',
				'考生信息列表' => '?signup,candidate',
			),
			'友情链接' => array(
				'友情链接列表' => '?link,showlist',
				'发布友情链接' => '?link,publish',
			),

			'系统维护' => array (
				'系统用户管理' => array (
					'用户列表' => '?system,userlist',
					'系统用户分组' => '?system,group',
					),
                                '基本信息维护' => '?system,company_info',
//                                '首页轮播广告' => '?mulupload,showlist,assoc_id,ad0,cate_id,ad0',
                               // '内页轮播广告' => '?mulupload,showlist,assoc_id,ad1,cate_id,ad1',
                               // '图片管理' => '?mulupload,showlist',
				'系统类别管理' => array (
					'类别管理' => '?system,category',
					'添加新类别' => '?system,category,action,add,pid,1'
					),
//				'开发者菜单' => array (
//					'管理权限定义' => '?system,permissions',
//					'会员组权限定义' => '?member,permissions'
//					)
				),
			'个人资料' => array (
				'我的资料' => '?default,myinfo',
				'修改密码' => '?default,changepasswd'
				),
			);
	$mm = new MakeMenu($menu, $current);
	
	return $mm->text;
}
class MakeMenu {
	var $text = '';
	var $lev = -1;
	var $highlight;
	
	function MakeMenu($data, $highlight= null){
		$this->highlight = $highlight;
		$this->_make($data);
	}
	function _make($data) {
		//注意:生成菜单的时候HTML Tags之前不要有多余的空格或字符,否则可能引起JavaScript错误
		$this->lev += 1;	//级数加一
		if($this->lev){		//区分主次菜单
			$this->text .= "<div class='lev$this->lev'>";
			$main = false;
		}else{
			$this->text .= "<div id='mb_menu'>";
			$main = true;
		}
		
		foreach($data as $k => $v) {
			$link= " href='$v'";
			$hl = $this->highlight == $k? true : false;
			
			if (is_array($v)) {
				$this->text .= "<div class='cMenu'><a href='javascript:void(0)'".$this->setClass($hl, $main)."><span>$k</span></a>";
				$this->_make($v);
				$this->text .= "</div>";
			} else {
				$this->text .= "<a$link".$this->setClass($hl, $main)."><span>$k</span></a>";
			}
		}
		$this->lev -= 1; //退到上一级
		$this->text .= "</div>";
	}
	function setClass($hl, $main){
		if($hl&&$main){
			return " class='main hlight'";
		}else if($hl){
			return " class='hlight'";
		}else if($main){
			return " class='main'";
		}
	}
}
?>
