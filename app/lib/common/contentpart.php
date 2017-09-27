<?php
/***************************************************************
 * 内容分页处理
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
/**
 * 针对$content中的"[[page]]"标记处进行分页,
 * 返回分页后的第n页,并带有页面索引
 * @param string $url 页面索引的链接
 * @param string $content 文本内容
 * @param int $part 指定返回的部份
 */
function contentPart($url, $content, $part){
	$part = abs($part);
	$content = explode('[[page]]',$content);
	$totalPart = count($content);
	if($part >= $totalPart){
		Core::raiseMsg('对不起!该页不存在,请返回操作......');
	}
	$content = $content[$part];
	$content = contentPager($url, $totalPart, $part, 'right')
		.$content
		.contentPager($url, $totalPart, $part);
	return $content;
}
function contentPager($url, $totalPart, $currentPart, $align = 'center') {
	if($totalPart <=1)
		return;
	$numPrePage = 10;$half= 5;
	$url = preg_replace('!,part,\d+!','',$url);
	$outstr= "<div style=\"font:12px bold '宋体';\" class='partindex' align='$align'> 共 $totalPart 页";
	$outstr .= ($currentPart > 0) ? " <a href=\"$url,part,". ($currentPart -1)."\">上一页</a>" : " 上一页";
	if($totalPart > $half*2 && ($currentPart >$half)){
		if(($currentPart+$half)<$totalPart){
			$j=$currentPart+$half+1;
			$i=$currentPart-$half;
		}
		else {
			$j=$totalPart;
			$i=$currentPart-($half * 2 -($j-$currentPart));
		}
	}else {
		$i = 0;
		$j = $totalPart>$half * 2+1?$half*2+1:$totalPart;
	}
	for (; $i < $j; $i ++) {
		$outstr .= ($i == $currentPart) ? " <strong>[". ($i +1)."]</strong>" : " <a href=\"$url,part,$i\">[". ($i +1)."]</a>";
	}
	$outstr .= ($currentPart +1 < $totalPart) ? " <a href=\"$url,part,". ($currentPart +1)."\">下一页</a>" : " 下一页";
	return $outstr."</div>";
	
}
?>