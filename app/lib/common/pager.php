<?php
/***************************************************************
 * 分页函数
 * 
 * @author yeahoo2000@163.com
 ***************************************************************/


/**
 * 生成数据分页索引
 * @param string $url 显示页面的Url
 * @param int $totalRecord 总记录数
 * @param int $currentPage 当前页
 * @param int $numPrePage 每页显示的记录数
 * @param int $half 往左右廷伸的索引个数,默认为5个
 * @return string html字串
 */
function pageIndex($url, $totalRecord, $currentPage, $numPrePage, $half= 5) {
	$url = preg_replace('!,page,\d+!','',$url);
	$totalPage= $numPrePage > $totalRecord ? 1 : $totalRecord % $numPrePage ? (int) ($totalRecord / $numPrePage) + 1 : (int) ($totalRecord / $numPrePage);
	$currentPage = ($currentPage >0 && $currentPage < $totalPage) ? (int)$currentPage : 0;
	$outstr= "<div style=\"font:12px bold '宋体';\" class='pageindex'> ";
	$outstr .= ($currentPage > 0) ? " <a href=\"$url,page,". ($currentPage -1)."\">&lt;&lt;=</a>" : " &lt;&lt;=";
	if($totalPage > $half*2 && ($currentPage >$half)){
		if(($currentPage+$half)<$totalPage){
			$j=$currentPage+$half+1;
			$i=$currentPage-$half;
		}
		else {
			$j=$totalPage;
			$i=$currentPage-($half * 2 -($j-$currentPage));
		}
	}else {
		$i = 0;
		$j = $totalPage>$half * 2+1?$half*2+1:$totalPage;
	}
	for (; $i < $j; $i ++) {
		$outstr .= ($i == $currentPage) ? " <strong>[". ($i +1)."]</strong>" : " <a href=\"$url,page,$i\">[". ($i +1)."]</a>";
	}
	$outstr .= ($currentPage +1 < $totalPage) ? " <a href=\"$url,page,". ($currentPage +1)."\">=&gt;&gt;</a>" : " =&gt;&gt;";
	//$goto= " <input type='text' id='page_num' name='page_num' size='2' value='". ($currentPage +1)."' onFocus='this.select()' style='text-align:right;'> <input type='button' name='goto_page' value='>>>' style='height:20px;margin:0;' onClick=\"if(". ($currentPage +1)." != document.getElementById('page_num').value)window.location.replace('".$url.",page,'+(document.getElementById('page_num').value-1));\">\n";
	$goto = ($half * 2 +1)< $totalPage ?"<input type='button' name='goto_page' value='>>>' style='height:20px;' onclick=\"var page=prompt('请输入你想跳转到的页数(1-{$totalPage}):','');if(page>0&&page<=$totalPage){window.location.replace('$url'+',page,'+(page-1));}\">":'';
	return $outstr.' Page '.($currentPage+1)."/ ".$totalPage." (Total ".$totalRecord." Records) $goto </div>";
	//return $outstr.' '.($currentPage+1)."/$totalPage($totalRecord) $goto </div>";

}
/**
 * 生成数据分页索引
 * @param string $url 显示页面的Url
 * @param int $totalRecord 总记录数
 * @param int $currentPage 当前页
 * @param int $numPrePage 每页显示的记录数
 * @param int $half 往左右廷伸的索引个数,默认为5个
 * @return string html字串
 */
function pageIndex2($url, $totalRecord, $currentPage, $numPrePage, $half= 5) {
	$url = preg_replace('!,page,\d+!','',$url);
	$totalPage= $numPrePage > $totalRecord ? 1 : $totalRecord % $numPrePage ? (int) ($totalRecord / $numPrePage) + 1 : (int) ($totalRecord / $numPrePage);
	$currentPage = ($currentPage >0 && $currentPage < $totalPage) ? (int)$currentPage : 0;
	$outstr= "<div style=\"font:12px bold '宋体';\" class='pageindex'> ";
	$outstr .= ($currentPage > 0) ? " <a  class=\"prev\" href=\"$url,page,". ($currentPage -1)."\">&nbsp;&nbsp;<img src=\"images/prev_g.png\" />&nbsp;&nbsp;</a>" : "&nbsp;&nbsp;<a class=\"prev\"><img src=\"images/prev_g.png\" /></a>&nbsp;&nbsp;";
	if($totalPage > $half*2 && ($currentPage >$half)){
		if(($currentPage+$half)<$totalPage){
			$j=$currentPage+$half+1;
			$i=$currentPage-$half;
		}
		else {
			$j=$totalPage;
			$i=$currentPage-($half * 2 -($j-$currentPage));
		}
	}else {
		$i = 0;
		$j = $totalPage>$half * 2+1?$half*2+1:$totalPage;
	}
	for (; $i < $j; $i ++) {
		$outstr .= ($i == $currentPage) ? " <a class=\"pg\">". ($i +1)."</a>" : " <a class=\"pg\" href=\"$url,page,$i\">". ($i +1)."</a>";
	}
	$outstr .= ($currentPage +1 < $totalPage) ? " <a href=\"$url,page,". ($currentPage +1)."\" class=\"next\">&nbsp;&nbsp;<img src=\"images/next_g.png\" />&nbsp;&nbsp;</a>" : "&nbsp;&nbsp;<a class=\"next\"><img src=\"images/next_g.png\" /></a>&nbsp;&nbsp;";
	//$goto= " <input type='text' id='page_num' name='page_num' size='2' value='". ($currentPage +1)."' onFocus='this.select()' style='text-align:right;'> <input type='button' name='goto_page' value='>>>' style='height:20px;margin:0;' onClick=\"if(". ($currentPage +1)." != document.getElementById('page_num').value)window.location.replace('".$url.",page,'+(document.getElementById('page_num').value-1));\">\n";
	$goto = ($half * 2 +1)< $totalPage ?"<input type='button' name='goto_page' value='>>>' style='height:20px;' onclick=\"var page=prompt('请输入你想跳转到的页数(1-{$totalPage}):','');if(page>0&&page<=$totalPage){window.location.replace('$url'+',page,'+(page-1));}\">":'';
	///return $outstr.' 当前第'.($currentPage+1)."页/共".$totalPage."页(共".$totalRecord."条记录) $goto </div>";
	return $outstr.'</div>';
}
?>