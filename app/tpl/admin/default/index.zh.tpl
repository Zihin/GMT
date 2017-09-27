<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GMT网站管理系统</title>
</head>
<body>
<?php plugin('admin_header');?><form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','首页');?>
      <script language="javascript">var m = new Menu('menu');</script></td>
    <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onClick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
    <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
          <h1>
            <?=$v['title']?>
          </h1>
      <div class="boxcontent">
        <table width="100%" border="0" cellpadding="5" cellspacing="0">
          <tr>
            <td><h3>欢迎使用GMT网站管理系统</h3>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr>
              提示:为了保证系统安全,在管理工作结束后请点击&quot;退出&quot;按钮退出系统<br>
              <br>
              <br></td>
          </tr>
        </table>
      </div>
      <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></div></td>
  </tr>
</table></form>
</body>
</html>