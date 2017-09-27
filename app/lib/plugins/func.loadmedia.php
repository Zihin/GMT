<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 生成能够显示相应格式媒体文件(.gif .jpg .swf等)的HTML代码
 * @param string $iurl 媒体文件路径
 * @param int $width 显示宽度
 * @param string $height 显示高度
 * @param bool $clickMax 点击放大,.swf格式不起作用
 * @return string HTML代码
 */
function func_loadmedia($iurl, $width, $height, $clickMax=false) {
	$ext = substr($iurl, strrpos($iurl, '.'), strlen($iurl));
	if('.swf' == $ext){
		return '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="'.$width.'" height="'.$height.'" ><param name="movie" value="'.$iurl.'" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><embed src="'.$iurl.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" wmode="transparent"></embed></object>';
	}else{
		$clickMax = $clickMax?' onclick="winOpen(this.src,520,460,1);" style="cursor:pointer;"':'';
		return '<img src="'.$iurl.'" width="'.$width.'" height="'.$height.'" onload="resizeImg(this,'.$width.','.$height.')"'.$clickMax.' />';
	}
}
?>