<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$v['title']?></title>
</head>

<body>
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','用户列表');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                <?=$v['title']?>
              </h1>
        <div class="boxcontent">
                <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbox">
                  <tr>
                    <td width="120" class="label"><input name="item[id]" type="hidden" id="item[id]" value="<?=$v['item']['id']?>" />
                      是否激活:</td>
                    <td bgcolor="#FFFFFF"><?=$v['item']['actived']?>
                        <span class="red">*</span>
                        <?=$v['emsg']['actived']?></td>
                  </tr>
                  <tr>
                    <td class="label"> 登录名:</td>
                    <td bgcolor="#FFFFFF"><input name="item[username]" type="text" id="item[username]" value="<?=$v['item']['username']?>" />
                        <span class="red">*</span>
                        <?=$v['emsg']['username']?></td>
                  </tr>
                  <tr>
                    <td class="label">用户组:</td>
                    <td bgcolor="#FFFFFF"><?=$v['item']['gid']?>
                        <span class="red">*</span>
                        <?=$v['emsg']['gid']?></td>
                  </tr>
                  <tr>
                    <td class="label">密码:</td>
                    <td bgcolor="#FFFFFF"><input name="item[passwd]" type="text" id="item[passwd]" />
                        <?=$v['emsg']['passwd']?></td>
                  </tr>
                  <tr>
                    <td class="label">确认密码:</td>
                    <td bgcolor="#FFFFFF"><input name="item[passwd1]" type="text" id="item[passwd1]" />
                        <?=$v['emsg']['passwd1']?></td>
                  </tr>
                  <tr>
                    <td class="label">电子邮箱</td>
                    <td bgcolor="#FFFFFF"><input name="item[email]" type="text" id="item[email]" value="<?=$v['item']['email']?>" size="36" maxlength="100" />
                        <?=$v['emsg']['email']?>                    </td>
                  </tr>
                  <tr>
                    <td class="label">其它资料:</td>
                    <td bgcolor="#FFFFFF"><textarea name="item[intro]" cols="64" rows="6" id="item[intro]"><?=$v['item']['intro']?></textarea></td>
                  </tr>
                  <tr>
                    <td class="label">&nbsp;</td>
                    <td bgcolor="#FFFFFF"><input name="submit" type="submit" id="submit" value=" 提交 " class="btn_b" />
                        <input name="goback" type="button" id="goback" value=" 返回 " class="btn_b" onclick="location.replace('<?=$v['goback']?>');"/></td>
                  </tr>
                </table>
        </div>
        <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b> </div></td>
    </tr>
  </table>
</form>
</body>
</html>
