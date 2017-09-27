<?php
/***************************************************************
 * 生成图片动态码,用于增强登录安全
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class DyncodeImg extends Action{
	var $AuthLevel = ACT_OPEN;
	
	function process(){
		//生成一个动态码
		$dynCode = plugin('rand_string',4,'0123456789');
		$this->sess->set('dyncode',$dynCode);
		$im =imagecreate(52,18);
		$black = ImageColorAllocate($im,0,0,0);
		$white = ImageColorAllocate($im, 255,255,255);
		$gray =ImageColorAllocate($im, 200,200,200);
		imagefill($im,0,0,$gray);
		for($i=0;$i<400;$i++){
			$randcolor =ImageColorallocate($im,rand(10,255),rand(10,255),rand(10,255));
			imagesetpixel($im, rand()%90 , rand()%30 ,$randcolor);
		}
		for($i=0;$i<5;$i++){
			imageline($im,rand(0,80),rand(0,80),rand(0,80),rand(0,80),$black);
		}
		imagestring($im, 8, 10, 0,$dynCode,$black);
		Header("Content-type: image/jpeg");
		Imagejpeg($im);
		ImageDestroy($im);
	}
}
?>