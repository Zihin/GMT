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