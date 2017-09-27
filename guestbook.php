<?php
//单页面的头部请加上这一部份的代码
include_once 'app/etc/front.config.php';
include_once LIB_DIR.'/core.php';
include_once LIB_DIR.'/errorhandler.php';
include_once LIB_DIR.'/global.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="加盟连锁七张嘴兒七品焖锅">
<meta name="description" content="加盟连锁七张嘴兒七品焖锅 ">
<meta name="author" content="加盟连七张嘴兒七品焖锅 ">
<title>七张嘴兒 七品焖锅 百年焖锅 享所未想 欢迎加盟</title>
<link type="text/css" rel="stylesheet" href="css/main.css"/>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>

</head>
<body>
<!--头部 -->
<!--logo <embed src="music/love.mp3" autostart="true" loop="true" width="0" height="0" >-->
<div style="width:100%; height:auto;background-color:#FFCD00;">
<div style="width:96%; height:auto;background-color:#FFC;">

<?php plugin('page_header'); ?>
<?php include TPL_DIR . '/front/nav.' . LANGUAGE . '.tpl';?>
<div class="showder"></div>

<div class="main9">
<div class="content">
        <table width="100%" align="center" >
        <form action="#" method="post" name="form1" id="form1" onsubmit="return chkfiled(this);">
          <tr> </tr>
          <tr align="center"> </tr>
          <tr>
            <td height="13"><div align="center">姓 
              名</div></td>
            <td width="91%" height="13"><input class="text input230" name="realname" type="text"  id="realname" size="40" maxlength="20" />
              * 您的真实姓名，请使用中文</td>
          </tr>
          <tr>
            <td><div align="center">电 话</div></td>
            <td width="91%"><input class="text input230"  name="tel" type="text"  id="tel" size="40" maxlength="20" />
              * 电话是您的重要联系方式，请正确填写 </td>
          </tr>
          <tr>
            <td align="center"> 地 址</td>
            <td width="91%"><input class="text input230"  name="address" type="text"  id="address" size="40" maxlength="50" />
              (可不填)请输入您的联系地址，以保证资料邮递 </td>
          </tr>
          <tr>
            <td align="center">邮 编</td>
            <td width="91%"><input name="postcode" type="text"  id="postcode" size="40" maxlength="20" class="text input230" />
              (可不填)请输入您的邮政编码 </td>
          </tr>
          <!--  <tr>
          <td><div align="center">主 题</div></td>
          <td width="91%"><input style="width:200px;"  name="topic" type="text"  id="topic" size="40" maxlength="40" />

          </td>
        </tr> -->
          <tr>
            <td><div align="center">E-mail</div></td>
            <td width="91%"><input class="text input230"  name="email" type="text"  size="40" maxlength="40" />
              (可不填)请正确填写电子信箱,以便给您发送相关资料</td>
          </tr>
          <tr>
            <td><div align="center">留 言</div></td>
            <td width="91%"><textarea  style="width:400px; 	background-color: #ffffff;
	border: 1px solid #f8ac98;"  name="content" cols="70" rows="6"   ></textarea>
            </td>
          </tr>
          <tr height="20">
            <td colspan="2"><div align="left">何处知七张嘴七品焖锅的： </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="91%" valign="top"><input 

                                name="know" type="checkbox" class="d" id="know" value="央视" />
              央视&nbsp;
&nbsp;
&nbsp;
<input 

                                name="know" type="checkbox" class="d" id="know" value="招商平台" />
              招商平台&nbsp;
              <input 

                                name="know" type="checkbox" class="d" id="know" value="搜狐网" />
              搜狐网
                
              &nbsp;
<input 

                                name="know" type="checkbox" class="d" id="know" value="新浪网" />
              新浪网&nbsp;&nbsp;

              <input 

                                name="know" type="checkbox" id="know" value="其他网站" />
              其他网站<br />
              <input 

                                name="know" type="checkbox" id="know" value="百度搜索引擎" />
              百度搜索&nbsp;
              <input 

                                name="know" type="checkbox" id="know" value="网络招商平台" />
              网络招商&nbsp;
              <input 

                                name="know" type="checkbox" id="know" value="电视" />
              电视 &nbsp;&nbsp;&nbsp;

              <input 

                                name="know" type="checkbox" id="know" value="报纸" />
              报纸&nbsp; &nbsp;&nbsp;
              <input 

                                name="know" type="checkbox" id="know" value="杂志" />
              杂志</td>
          </tr>
          <tr>
            <td height="40" colspan="2" align="center"><input type="submit" name="Submit3" value="递交" class="button"/>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <input id="__BKURL__" name="__BKURL__" type="hidden" value="" />
              <input id="act" name="act" type="hidden" value="add" />
              <input type="reset" name="Submit4" value="重写" class="button" />
            </td>
          </tr>
          </form>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        <script language="JavaScript" type="text/javascript">
document.getElementById("__BKURL__").value=document.location.href;
function checkspace(checkstr) {
var str = '';
 for(i = 0; i < checkstr.length; i++) {
 str = str + ' ';
 }
 return (str == checkstr);
}

function chkfiled(form){
  var isReguser=/^[a-zA-Z]{1}([a-zA-Z0-9]|[._]){3,19}$/;
  var isChinese=/[\u4e00-\u9fa5]/;
  var isAge  = /^(1[0-2]\d|\d{1,2})$/;
  var isPhone =/\d{3}-\d{8}|\d{4}-\d{7}/;
  var isTel=/^[+]{0,1}(\d){1,3}[ ]?([-]?((\d)|[ ]){1,12})+$/; 
  var isEmail=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
  var isPost=/^[1-9]\d{5}$/;
  var isPostcode=/^[a-zA-Z0-9 ]{3,12}$/; 
  
   if(isChinese.test(form.realname.value)==false) {
	form.realname.focus();
    alert("对不起，请填写姓名！");
	return false;
}

/*if(isEmail.test(form.email.value)==false) {
	form.email.focus();
    alert("对不起，请确认你填写的E-mail！");
	return false;
    }*/
	
if(isTel.test(form.tel.value)==false) {
	form.tel.focus();
    alert("对不起，请填写联系电话！");
	return false;
}


  
 /*  if(isPostcode.test(form.postcode.value)==false) {
	form.postcode.focus();
    alert("对不起，请填写邮政编码！");
	return false;
}*/

 

}
      </script>
  </div>
</div>

<!--底部开始-->
<div class="ffmm"></div>
	<!--footer -->
<div class="footer">
<?php plugin('front_footer'); ?>
</div>

</div>
</div>

	<!--banner切换-->
<script src="js/fn.js"></script>
<script>
        $(document).ready(function() {
            var k_total_pics = $('.k_banner .pics li').length,
                k_html_str = '<div class="tabs">';
            for (var i = 0; i < k_total_pics; i++) {
                if (i == 0) {
                    k_html_str += '<b class="on"></b>';
                } else {
                    k_html_str += '<b></b>';
                }
            }
            k_html_str += '</div>';
            $('.k_banner').append(k_html_str);
            slidePics($('.k_banner .tabs b'), $('.k_banner .pics li'));
            autoSlide($('.k_banner .tabs b'), $('.k_banner .pics li'));
            function setPosition() {
                $('.k_banner .tabs').css({
                    left: ($('body').width() - $('.k_banner .tabs').width()) / 2
                });
            }
            setPosition();
            $(window).resize(function() {
                setPosition();
            });
        });
</script>

</body>
</html>

