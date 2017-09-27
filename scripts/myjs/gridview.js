/**
 * @author yeahoo2000@163.com
 */
var Grid = {
	init:function(tid){
		var colors = ['#fafafa','#ffffff'];
		Grid.hl = '#f0f0cc';
		
		var tb = $(tid);
		var tbody = tb.getElementsByTagName('tbody')[0];

		var elms = tbody.getElementsByTagName('input');
		var cbs = new Array();
		var rows = new Array();
		for(var i = 0; i < elms.length; i++){
			if('checkbox' == elms[i].type){
				cbs.push(elms[i]);
				rows.push(elms[i].parentNode.parentNode);
			}
		}
		if(rows.length){
			var btnC = getElementsByClassName('btnCheck', tid)[0];
			var btnUc = getElementsByClassName('btnUncheck', tid)[0];
			btnC.cbs = btnUc.cbs = cbs;
			btnC.onclick = Grid.checkAll;
			btnUc.onclick = Grid.uncheckAll;
			for(var i=0; i < rows.length; i++){
				rows[i].bgColor = rows[i].oBg = rows[i].oldBg = Grid.cycle(colors);
				rows[i].onmouseover = Grid.highlight;
				rows[i].onmouseout = Grid.revert;
				if(cbs[i].checked){
					rows[i].bgColor = rows[i].oBg = Grid.hl;
				}
				cbs[i].onclick = Grid.cbEvent;
			}
		}
	},
	checkAll:function(){
		for(i=0; i<this.cbs.length; i++){
			Grid.setCheckbox(this.cbs[i]);
		}
	},
	uncheckAll:function(){
		for(i=0; i<this.cbs.length; i++){
			Grid.setCheckbox(this.cbs[i], 0);
		}
	},
	setCheckbox:function(o, val){
		row = o.parentNode.parentNode;
		v = null == val? o.checked : !val;
		if(v){
			row.bgColor = row.oBg = row.oldBg;
			o.checked = 0;
			row.onmouseover = Grid.highlight;
			row.onmouseout = Grid.revert;
		}else{
			row.bgColor = row.oBg = Grid.hl;
			o.checked = 1;
			row.onmouseover = null;
			row.onmouseout = null;
		}
	},
	cbEvent:function(){
		if(this.checked){
			Grid.setCheckbox(this, true);
		}else{
			Grid.setCheckbox(this, false);
		}
	},
	highlight:function(){
		this.bgColor = '#dbeaf5';
	},
	revert:function(){
		this.bgColor = this.oBg;
	},
	cycle:function(values){
		if(Grid.vIndex == null){
			Grid.vIndex = 0;
		}
		var v = values[Grid.vIndex++];
		if(Grid.vIndex >= values.length){
			Grid.vIndex = 0;
		}
		return v;
	}
}