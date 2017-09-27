<?php
/***************************************************************
 * 类别相关接口
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

class Category {
	/**
	 * 类别选择器
	 * @param int $node 节点ID号
	 * @param string $name 选择器名称
	 * @param mixd $def 预选值
	 * @param bool $lower 是否限定只能选最底层节点
	 * @param array $cannotChoose 禁选项
	 * @param bool $auth 只列出有权限访问的节点供选择
	 * @return string HTML代码
	 */
	function selector($node, $name, $def= null, $lower= true, $cannotChoose= null, $auth= true) {
		$list= "<option value=''>请选择</option>\n";
		$data= Category :: getData($node);
		$child= Category :: getAllChild($node);
		array_shift($child);	//扔掉第一个元素
		if (count($child)) {
			foreach ($child as $v) {
				$cData= Category :: getData($v);
				$d= ($v == $def) ? 'selected' : '';
				$val= $lower ? $cData['child_num'] ? 'cannot' : $v : $v;
				if (is_array($cannotChoose)) { //判断当前节点是否在禁选项中
					$val= in_array($v, $cannotChoose) ? 'cannot' : $v;
				}
				$sepOffset = $cData['lev'] - $data['lev'] - 1;
				$sep = $sepOffset?str_repeat('&nbsp;&nbsp;&nbsp;', $sepOffset-1).'|--' : '';
				$list .= "<option value='$val' $d>$sep{$cData['title_'.LANGUAGE]}</option>\n";
			}
		} else {
			$list .= "<option value='{$data['id']}'".( strlen($def)? 'selected' : '' ).">{$data['title_'.LANGUAGE]}</option>\n";
		}
		return "<select name=\"$name\" id=\"$name\" onChange=\"if('cannot' =="."this.value){alert('这个类别是不允许选择的,请选择其它合适的类别...');"."this.options[0].selected=1;}\">\n".$list."</select>\n";
	}
	/**
	 * 类别选择器
	 * @param int $node 节点ID号
	 * @param string $name 选择器名称
	 * @param mixd $def 预选值
	 * @param bool $lower 是否限定只能选最底层节点
	 * @param array $cannotChoose 禁选项
	 * @param bool $auth 只列出有权限访问的节点供选择
	 * @return string HTML代码
	 */
	function selector_c($node, $name,$id, $def= null, $lower= true, $cannotChoose= null, $auth= true) {
		$list= "<option value=''>请选择考试中心</option>\n";
		$data= Category :: getData($node);
		$child= Category :: getAllChild($node);
		array_shift($child);	//扔掉第一个元素
		if (count($child)) {
			foreach ($child as $v) {
				$cData= Category :: getData($v);
				$d= ($v == $def) ? 'selected' : '';
				$val= $lower ? $cData['child_num'] ? 'cannot' : $v : $v;
				if (is_array($cannotChoose)) { //判断当前节点是否在禁选项中
					$val= in_array($v, $cannotChoose) ? 'cannot' : $v;
				}
				$sepOffset = $cData['lev'] - $data['lev'] - 1;
				$sep = $sepOffset?str_repeat('&nbsp;&nbsp;&nbsp;', $sepOffset-1).'|--' : '';
				$list .= "<option value='$val' $d>$sep{$cData['title_'.LANGUAGE]}</option>\n";
			}
		} else {
			$list .= "<option value='{$data['id']}'".( strlen($def)? 'selected' : '' ).">{$data['title_'.LANGUAGE]}</option>\n";
		}
		return "<select name=\"$name\" id=\"$id\">\n".$list."</select>\n";
	}
	/**
	 * 类别radio选择器
	 * @param int $node 节点ID号
	 * @param string $name 选择器名称
	 * @param mixd $def 预选值
	 * @return string HTML代码
	 */
	function radio($node, $name, $def= null) {
		$list= '';
		$head = " <input type='radio' id='$name' name='$name' value";
		$data= Category :: getData($node);
		$child= Category :: getChild($node);
		if (count($child)) {
			foreach ($child as $v) {
				$cData= Category :: getData($v);
				$d= ($v == $def) ? "checked='checked'" : '';
				$list .= "$head='$v' $d />{$cData['title_'.LANGUAGE]}\n";
			}
		} else {
			$list .= "$head='{$data['id']}'".( strlen($def)? "checked='checked'" : '' )." />".$data['title_'.LANGUAGE]."\n";
		}
		return $list;
	}
	
	/**
	 * 从类别数据缓存中取得相应ID的数据
	 * @param int $id 类别ID号
	 */
	function getData($id) {
		$cacheFile= VAR_DIR."/category/$id/data.cache";
		if (!is_file($cacheFile)) {
			Category :: _buildCache($id);
		}
		$data = unserialize(@file_get_contents($cacheFile));
		if(!$data){
			mylog(L_WRINING, "无法得到ID号为'$id'的类别数据");
			//Core::raiseMsg('系统中不存在此分类......');
		}
		return $data;
	}
	
	/**
	 * 取得相应类别的直接子类
	 * @param int $id 类别ID号
	 */
	function getChild($id) {
		$cacheFile= VAR_DIR."/category/$id/child.cache";
		if (!is_file($cacheFile)) {
			Category :: _buildCache($id, 'child');
		}
		return unserialize(file_get_contents($cacheFile));
	}
	
	/**
	 * 取得相应类别的所有子类
	 * @param int $id 类别ID号
	 */
	function getAllChild($id) {
		$cacheFile= VAR_DIR."/category/$id/allchild.cache";
		if (!is_file($cacheFile)) {
			Category :: _buildCache($id, 'allchild');
		}
		return unserialize(file_get_contents($cacheFile));
	}
	
	/**
	 * 取得指定的节点列表
	 * @param int $id 类别ID号
	 * @param string $link 链接地址
	 * @param string $target 链接的打开目标
	 * @return string 返回结构化的<UL>列表HTML字串
	 */
	function getList($id, $link, $target='_self', $lev= 1) {
		$child= Category :: getChild($id);
		$outStr .= "<ul class=\"lev$lev\">\n";
		foreach ($child as $v) {
			$data= Category :: getData($v);
			$a = CORE_SEF_QUERY_STRING? "<a href=\"$link,cate,{$data['id']}\" target=\"$target\">" : "<a href=\"$link&cate={$data['id']}\" target=\"$target\">";
			$outStr .= $data['child_num'] ? "<li>$a{$data['title_'.LANGUAGE]}</a>\n".Category :: getList($data['id'], $link, $target, $lev +1)."</li>\n" 
			: "<li>$a{$data['title_'.LANGUAGE]}</a></li>\n";
		}
		$outStr .= "</ul>\n";
		if(1 == $lev){
			$outStr = "<div class=\"catelist\">$outStr</div>\n";
		}
		return $outStr;
	}
	
	/**
	 * 返回类别路径
	 * @param int $id 类别ID号
	 * @param string $link 链接
	 * @param int $startLev 路径中显示的起始级别
	 * @param string $sep 分隔符 
	 */
	function getPath($id, $link = null, $startLev= 2, $sep=' >> ') {
		$data = Category::getData($id);
		$last = array_pop($data['path']);
		foreach($data['path'] as $v){
			if($v['lev'] < $startLev) continue;
			if($link){
				$l = CORE_SEF_QUERY_STRING ? "$link,cate,{$v['id']}" : "$link&cate={$v['id']}";
				$output .= "<a href=\"$l\">{$v['title_'.LANGUAGE]}</a>$sep";
			}else $output .= $v['title_'.LANGUAGE].$sep;
		}
		return $output.$last['title_'.LANGUAGE];
	}
	
	/**
	 * 返回指定类别的title
	 * @param int $id 类别ID号
	 * @return string
	 */
	function getTitle($id) {
		$data= Category :: getData($id);
		return $data['title_'.LANGUAGE];
	}
	/**
	 * 返回指定类别的最大记录容量
	 * @param int $id 类别ID号
	 * @return string
	 */
	function getMax($id) {
		$data= Category :: getData($id);
		return $data['max_num'];
	}
	
	/**
	 * 将指定类别的数据库资料缓存到文件
	 * @param int $id 类别ID号
	 * @param string $type 指定缓存的某部份数据(allchild | child | data)
	 */
	function _buildCache($id, $type= null) {
		if (!is_numeric($id)) {
			return;
		}
		$db= Core :: getDb();
		if(!$db->GetOne("select count(*) from ".TB_PREFIX."category where id = $id"))
			Core::raiseMsg("系统中不存在ID为'$id'的分类......");
		
		switch ($type) {
			case 'allchild' :
				{
					$allChild= Category :: _getAllChildArr($id);
					wfile(VAR_DIR.'/category/'.$id.'/allchild.cache', serialize($allChild));
				}
				break;
			case 'child' :
				{
					$sql= "select id from ".TB_PREFIX."category where pid=$id order by lft asc";
					$rs= $db->Execute($sql);
					$child= array ();
					while (!$rs->EOF) {
						$child[]= $rs->fields['id'];
						$rs->MoveNext();
					}
					wfile(VAR_DIR.'/category/'.$id.'/child.cache', serialize($child));
				}
				break;
			default :
				{
					$sql= "select * from ".TB_PREFIX."category where id=$id";
					$data= $db->GetRow($sql);
					$sql= "select c2.id as id, c2.title_zh as title_zh, c2.title_en as title_en, c2.lev as lev, c2.tpl_l as tpl_l, c2.tpl_v as tpl_v, c2.max_num as max_num from ".TB_PREFIX."category c1,".TB_PREFIX."category c2 where c1.lft between c2.lft and c2.rgt and c1.id=$id order by c2.lft asc";
					$data['path']= $db->GetAll($sql);
					if(!$data['tpl_l']){	//检查是否已设置列表显示模板,如没有则使用父类别的设置
						foreach(array_reverse($data['path']) as $v){
							if($v['tpl_l']){
								$data['tpl_l'] = TPL_DIR.'/'.$v['tpl_l'];
								break;
							}
						}
					}else $data['tpl_l'] = TPL_DIR.'/'.$data['tpl_l'];
					if(!$data['tpl_v']){	//检查是否已设置内容显示模板,如没有则使用父类别的设置
						foreach(array_reverse($data['path']) as $v){
							if($v['tpl_v']){
								$data['tpl_v'] = TPL_DIR.'/'.$v['tpl_v'];
								break;
							}
						}
					}else $data['tpl_v'] = TPL_DIR.'/'.$data['tpl_v'];
					wfile(VAR_DIR.'/category/'.$id.'/data.cache', serialize($data));
				}
		}
	}
	
	/**
	 * 从数据库中取得指定类别的所有子类ID号
	 * @param int $id 类别ID号
	 * @return array
	 */
	function _getAllChildArr($id) {
		$db= Core :: getDb();
		$sql= "select c1.id as id, c1.title_zh as title_zh, c1.title_en as title_en, c1.lft as lft, c1.rgt as rgt, c1.lev as lev from ".TB_PREFIX."category c1,".TB_PREFIX."category c2 where (c1.lft >= c2.lft) and (c1.lft <= c2.rgt) and c2.id=$id order by c1.lft asc";
		$rs= $db->Execute($sql);
		if(!$rs->RecordCount()){
			Core::raiseMsg('系统中不存在此分类......');
		}
		$arr= array ();
		while (!$rs->EOF) {
			$arr[]= $rs->fields['id'];
			$rs->MoveNext();
		}
		return $arr;
	}
}
?>
