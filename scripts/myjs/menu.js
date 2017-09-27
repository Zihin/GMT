/**
 *	菜单控制
 *	@param string|element mid 元素标识
 */
var Menu = function(mid){
	this.mid = $(mid) || document.body;
	this.cMenu = getElementsByClassName('cMenu',this.mid);
	for(var i=0; i<this.cMenu.length; i++){
		var h = this.cMenu[i].getElementsByTagName('a')[0];
		h.o = h.nextSibling.style;
		h.o.display = 'block';
		
		h.onclick = function(){
			if('none' == this.o.display){
				this.o.display = 'block';
			}else{
				this.o.display = 'none';
			}
		}
	}
	
	this.showToggle(0);
	var hl = getElementsByClassName('hlight')[0];
	if(hl) this._expandParent(hl);
}
Menu.prototype = {
	_expandParent:function(elm){
		var o = elm.parentNode;
		if(!o || o == this.mid)
			return;
		if((o.className.match(new RegExp("(^|\\s)lev[0-9](\\s|$)")))){
			o.style.display = 'block';
		}
		this._expandParent(o);
	},
	showToggle:function(s){
		s = s ? 'block' : 'none';
		for(var i=0; i<this.cMenu.length; i++){
			this.cMenu[i].getElementsByTagName('a')[0].nextSibling.style.display = s;
		}
	}
}