<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
if (top.location !== self.location) {
	top.location=self.location;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>欢迎登录</title>
<style type="text/css">
*{
  font:14px "宋体";
}
.winbox .b2b, .winbox .b3b, .winbox .b4b {background:#f0f8fe;}
</style>
<link href="scripts/global.css" rel="stylesheet" type="text/css" />
<script src="scripts/utils.js"></script>
</head>
<body>
<form id="main_form" name="main_form" action="<?=$v['form_act']?>" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="50">&nbsp;</td>
  </tr>
</table>
<div class="winbox" style="width:420px;margin:0 auto; text-align:left;"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
    <h1>欢迎登录系统</h1>
  <div class="boxcontent" style="font:14px/24px '宋体'; background-color:#f0f8fe; padding:15px 30px 5px 30px;">
    <table width="340" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td height="20" colspan="2" align="center"><?=$v['emsg']['msg']?></td>
      </tr>
      <tr>
        <td width="80" align="right" valign="top" style="padding:10px 0 0 0;">帐　号：</td>
        <td><input name="username" type="text" id="username" value="<?=$v['username']?>" style="width:150px;height:18px;"/>
          <?=$v['emsg']['username']?></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="padding:10px 0 0 0;">密　码：</td>
        <td><input name="password" type="password" id="password" style="width:150px;height:18px;"/>
          <?=$v['emsg']['password']?></td>
      </tr class="label">
      <?php if($v['login_times']>2): ?>
      <tr>
        <td align="right" valign="top" style="padding:10px 0 0 0;">动态码：</td>
        <td><input name="dyncode" type="text" id="dyncode" size="4" />
          <img src="<?=$v['dyncode_img']?>" alt="" width="50" height="20" align="absbottom" />
          <?=$v['emsg']['dyncode']?></td>
      </tr>
      <?php endif; ?>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="submit" value=" 登 录 " class="btn_b"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
  <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b> </div>
</form>
</body>
</html>