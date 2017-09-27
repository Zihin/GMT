/**
 *	以固定的显示尺寸显示内容,通点击切换显示完整内容和隐藏
 *	@param string|element pElement 父节点,默认为'document.body'
 *	@param string classHdn 隐藏时使用的CSS类,默认为'hdn'
 *	@param string classSho 完整显示时使用的CSS类,默认为'sho'
 */
function hidetext(pElement, classHdn, classSho){
	var cS = typeof classHdn == 'string' ? classSho : 'sho';
	var cH = typeof classHdn == 'string' ? classHdn : 'hdn';
	var pElement = $(pElement) || document.body;
	var elms = getElementsByClassName(cH, pElement);
	pElement.lastOpen = null;
	for(var i=0; i<elms.length; i++){
		elms[i].oldZi = elms[i].style.zIndex;
		if(!elms[i].childNodes.length){
			elms[i].style.display='none';
		}else{
			elms[i].onclick = function(){
				if(this.className == cS){
					this.className = cH;
					this.style.zIndex = this.oldZi;
				}else{
					if(pElement.lastOpen){
						pElement.lastOpen.className = cH;
						pElement.lastOpen.style.zIndex = pElement.lastOpen.oldZi;
					}
					pElement.lastOpen = this;
					this.className = cS;
					this.style.zIndex = 999;
				}
			}
		}
	}
}
