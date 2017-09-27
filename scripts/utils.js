function resizeImg(	ImgD			//图片对像
,image_width	//图片最大宽度
,image_height	//图片最大高度
){
	//等比例限定图片大小
	var flag=false; 
	var image=new Image(); 
	image.src=ImgD.src; 
	if(image.width>0 && image.height>0){ 
		flag=true; 
		if(image.width/image.height>= image_width/image_height){ 
			if(image.width>image_width){   
				ImgD.width=image_width; 
				ImgD.height=(image.height*image_width)/image.width; 
			}else{ 
				ImgD.width=image.width;   
				ImgD.height=image.height; 
			} 
		} 
		else{ 
			if(image.height>image_height){   
				ImgD.height=image_height; 
				ImgD.width=(image.width*image_height)/image.height;      
			}else{ 
				ImgD.width=image.width;   
				ImgD.height=image.height; 
			} 
		} 
    } 
}
function winOpen(	src		//窗口内容地址
,width	//宽度
,height	//高度
,s		//是否允许滚动条
){
	//弹出窗口并自动居中显示
	s = (s)?',resizable=1,scrollbars=yes':'';
	aa=window.open(src,'_blank','width='+width+','+'height='+height+s);
	b=screen.width;
	c=screen.height;
	b=(b-width)/2;
	c=(c-height)/2;
	aa.moveTo(b,c);
}
function loadMedia(showArea, iurl){
	outBox = document.getElementById(showArea);
	ext = iurl.substr(iurl.lastIndexOf('.'), iurl.length);
	maxW = parseInt(outBox.style.width);
	maxH = parseInt(outBox.style.height);
	 
	if('.swf' == ext){
		output = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="' + maxW + '" height="' + maxH + '"><param name="movie" value="'+ iurl + '" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><embed src="' + iurl + '" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="' + maxW + '" height="' + maxH + '" wmode="transparent"ss></embed></object>';
	}else{
		var img = new Image();
		img.src = iurl;
		output = '<img src="' + iurl +'" width="100" height="100" onload="resizeImg(this,' + maxW + ',' + maxH + ')" onclick="winOpen(this.src,520,460,1);" style="cursor:pointer;" />'
	}
	return output;
}