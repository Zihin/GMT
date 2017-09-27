if (!('placeholder' in document.createElement('input'))) {//判断浏览器是否支持placeholder属性，不支持则扩展
        //让IE7-支持display inline-block css，因为password类型需要用dom来模拟
        document.write('<style>div.placeholder{display:inline;zoom:1;position:relative;}input.placeholder{color:#999}div.placeholder div.note{font-size:12px;color:#333;position:absolute;left:10px;top:-5px;}</style>');
        $.fn.placeholder = function (config) {
            return this.each(function () {
                var me = $(this), pl = me.attr('placeholder');
                if (this.type == 'password') {//为密码域不能通过val来设置值显示内容，会显示星号，只能用dom来模拟
                    var wrap = me.wrap('<div class="placeholder" style="width:' + me.outerWidth(true) + 'px;height:' + me.outerHeight(true) + 'px"></div>').parent();
                    var note = wrap.append('<div class="note" style="line-height:' + me.outerHeight(true) + 'px">' + pl + '</div>')
                    .click(function () {
                        wrap.find('div.note').hide(); me.focus();
                    }).find('div.note');
                    me.blur(function () {
                        if (me.val() == '') note.show();
                    });
                }
                else { //非密码域使用val设置placeholder值
                    me.focus(function () {
                        me.removeClass('placeholder');
                        if (this.value == pl) this.value = '';
                    }).blur(function () {
                        if (this.value == '') me.val(pl).addClass('placeholder');
                    }).trigger('blur').closest('form').submit(function () {
                        if (me.val() == pl) me.val('');
                    });
                }
            });
        }
        //扩展方法clearPlaceholderValue：提交数据前执行一下，清空和placeholder值一样的控件内容。防止提交placeholder的值。
        //用于输入控件不在表单中或者使用其他代码进行提交的，不会触发form的submit事件，记得一定要执行此方法
        //是否要执行这个方法，可以判断是否存在此扩展
        //DMEO:if($.fn.clearPlaceholderValue)$('input[placeholder],textarea[placeholder]').clearPlaceholderValue()
        $.fn.clearPlaceholderValue = function () {
            return this.each(function () {
                if (this.value == this.getAttribute('placeholder')) this.value = '';
            });
        }
        
        $(function () {
            $('input[placeholder],textarea[placeholder]').placeholder();
        });
    }