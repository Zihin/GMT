/**
 *      按比例缩放图片
 *      @param object img 图片对象
 *      @param int maxW 允许的最大宽度
 *      @param int maxH 允许的最大高度
 *		@author yeahoo2000@163.com
 */
function fixImg (img, maxW, maxH){
    var oImg = new Image();
    oImg.src = img.src;
    var oRatio = oImg.width / oImg.height;
    var ratio = maxW / maxH;
    if(oImg.width > maxW && oRatio >= ratio){
        img.height = maxW / oRatio;
        img.width = maxW;
    }else if (oImg.height > maxH  && oRatio <= ratio){
        img.width = maxH * oRatio;
        img.height = maxH;
    }
}

//弹出窗口
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

//载入Flash或图片文件
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


//购物车代码
var shoppingCart = null;
function showShoppingCart(src){ 
    width = 500;
    height = 280;
    win=window.open(src,'ShoppingCart','width='+width+','+'height='+height+',resizable=1,scrollbars=yes');
    w=screen.width;
    h=screen.height;
    w= w-width-50;
    h= h-height-120;
    win.moveTo(w,h);
    return win;
}
function addItem(src){
    if(shoppingCart && !shoppingCart.closed){
        shoppingCart.location.replace(src);
    }
    else{
        shoppingCart = showShoppingCart(src);
    }
    shoppingCart.focus();
}
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^


/**
 *	document.getElementById的缩写,可同时获取多个元素
 *	(来自prototype.js的代码)
 */
function $() {
    var elms = new Array();
    for (var i = 0; i < arguments.length; i++) {
        var e = arguments[i];
        if (typeof e == 'string')
            e = document.getElementById(e);
        if (arguments.length == 1) 
            return e;
        elms.push(e);
    }
    return elms;
}

/**
 *	通过类名取得节点(参考自prototype.js代码)
 *	@param string className 类名
 *	@param string|element 父节点
 */
function getElementsByClassName(className, pElement) {
    var child = ($(pElement) || document.body).getElementsByTagName('*');
    var elms = new Array();
    for (var i = 0; i < child.length; i++)
        if(child[i].className.match(new RegExp("(^|\\s)" + className + "(\\s|$)")))
            elms.push(child[i]);
    return elms;
}
