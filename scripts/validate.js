$.fn.validate = function(els){
	if(this.is('form')){
		return this.submit(function(){return $.vdForm.validate(els)});
	}
}
$.vdForm = {
	validate:function(els){
		var result = true;
		for(i=0; i<els.length; i++){
			var el = document.getElementsByName(els[i].name)[0];
			for(j=0; j<els[i].rules.length; j++){
				var p = els[i].rules[j].rule.split(':');
				var r = p[0];
				p = p.slice(1);
				
				var msgbox = document.getElementById(els[i].name+'_msg');
				if(rules[r]($(el).val(), el, p, $.vdForm.utility)){
					//alert(els[i].rules[j].emsg);
					msgbox.innerHTML = els[i].rules[j].emsg;
					msgbox.style.display = 'block';
					result = false;
					break;
				}else{
					msgbox.style.display = 'none';
				}
			}
		}
		return result;
	}
}
$.vdForm.utility = {
	countChecked: function(el) {
		var num = 0;
		var els = document.getElementsByName(el.name);
		for(var i=0, el; el = els[i]; i++) {
			if(el.checked) {
				num++;
			}
		}
		return num;
	},
	
	getLength: function(value, element) {
		var length;
		switch( element.nodeName.toLowerCase() ) {
		case 'select':
			length = this.getSelectedOptions(element).length;
			break;
		case 'input':
			switch( element.type.toLowerCase() ) {
				case 'checkbox':
					length = this.countChecked(element);
					break;
				default: 
					length = value.length;
			}
			break;
		default: 
			length = value.length;
		}
		return length;
	},

	/**
	 * Returns an array of all selected options of a
	 * select element. Very useful to validate a select
	 * with multiple="multiple".
	 */
	getSelectedOptions: function(select) {
		return $("option:selected", select).get();
	},
	
	isRadioButtonSelected: function(radio) {
		var elements = document.getElementsByName(radio.name);
		for(var i=0, element; element = elements[i]; i++) {
			if(element.checked) {
				return true;
			}
		}
		return false;
	}
}
rules = {
	/**
	 * Return true if the element is empty.
	 * Works with all kind of text inputs, select and checkbox.
	 * To force a user to select an option from a select box, provide
	 * an empty options like <option value="">Choose...</option>
	 */
	required: function(value, element, parameters, utility) {
		switch( element.nodeName.toLowerCase() ) {
		case 'select':
			var options = utility.getSelectedOptions(element);
			return options.length == 0 || options[0].value.length == 0;
		case 'input':
			switch( element.type.toLowerCase() ) {
			case 'checkbox':
				return utility.countChecked(element) == 0;
			case 'radio':
				return utility.countChecked(element) == 0;
			default:
				return value.length == 0;
			}
		default:
			return value.length == 0;
		}
	},
	
	/**
	 * Return true, if the element is
	 * - some kind of text input and its value is too short or too long
	 * - a select and has not enough or too many options selected
	 * Works with all kind of text inputs and select.
	 */
	length: function(value, element, parameters, utility) {
		var length = utility.getLength(value, element);
		//alert('length:'+length+'  p0:'+ parameters[1]+'  p1:'+parameters[2]);
		return length < parameters[0] || length > parameters[1];
	},
	
	/**
	 * Return true, if the value is not a valid email address.
	 * Works with all kind of text inputs.
	 */
	email: function(value) {
		return !value.match(/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i);
	},
	
	/**
	 * Return true, if the value is not a valid url.
	 * Works with all kind of text inputs.
	 * WARNING: Is not fully implemented yet, eg. it does not allow a query string.
	 * @see http://www.w3.org/Addressing/rfc1738.txt
	 */
	url: function(value) {
		return !value.match(/^(https?|ftp):\/\/[A-Z0-9](\.?[A-Z0-9][A-Z0-9_\-]*)*(\/([A-Z0-9][A-Z0-9_\-\.]*)?)*(\?([A-Z0-9][A-Z0-9_\-\.%\+=&]*)?)?$/i);
	},
	
	/**
	 * Return true, if the value is a valid date.
	 * Works with all kind of text inputs.
	 * WARNING: Limited due to the capability of the JS Date object
	 * Use dateDE to check german dates.
	 */
	date: function(value) {
		return /Invalid|NaN/.test(new Date(value));
	},
	
	/**
	 * Checks a date according to german oldschool standard (not ISO).
	 * eg. 25.03.2006 or 1.5.05
	 * WARNING: Does not make sanity checks, eg. for 50.13.06 or 30.03.05
	 */
	dateDE: function(value) {
		return !value.match(/\d\d?\.\d\d?\.\d\d\d?\d?/);
	},
	
	/**
	 * 如果被检查的值不是有效的数字,或值不在指定范围内,则返回 "True"
	 */
	number: function(value, element, parameters, utility) {
		value -= 0;
		return value != value || value < parameters[0] || value > parameters[1];
	}
};