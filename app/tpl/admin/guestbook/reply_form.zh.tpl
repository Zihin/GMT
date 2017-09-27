<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITE_NAME;?></title>

<script type="text/JavaScript" src="scripts/editor/js/dialogEditorShared.js"></script> 
<script type="text/javascript" src="scripts/editor.js"></script>

<style type="text/css">
@import url(scripts/calendar/calendar-system.css);.subject {font:bold 14px "宋体";
	line-height:22px;
}
</style>
<script type="text/javascript" src="scripts/calendar/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar/lang/calendar-zh.js"></script>
<script type="text/javascript" src="scripts/calendar/calendar-setup.js"></script>
</head>

<body>
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','客户留言管理');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                <?=$v['title']?>
              </h1>
        <div class="boxcontent">
                <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbox">
                  <tr>
                    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                        <tr>
                          <td colspan="2" bgcolor="#f0f0d0"><span class="subject"><img src="imgs/smileys/<?=$v['item']['smileys']?>.gif" align="absbottom" /> 主题:
                            <?=$v['item']['subject']?>
                          </span></td>
                        </tr>
                        <tr>
                          <td width="120" rowspan="2" align="center" bgcolor="#fafafa"><img src="imgs/<?=$v['item']['g_photo']?>"/><br />
                              <?=$v['item']['g_province']?>
                              <b>
                              <?=$v['item']['g_name']?>
                              </b>
                              <?=$v['item']['g_sex']?>
                              <br />
                              <?=$v['item']['put_time']?></td>
                          <td valign="top"><?=$v['item']['content']?></td>
                        </tr>
                        <tr>
                          <td height="22"><b>电子邮箱:</b> <a href="mailto:<?=$v['item']['g_email']?>">
                            <?=$v['item']['g_email']?>
                            </a> <b>电话:</b>
                            <?=$v['item']['g_phone']?>
                            <b>联系地址:</b>
                            <?=$v['item']['g_addr']?></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td width="120" align="right" valign="top" class="label">回复内容:
                      <input name="item[id]" type="hidden" id="item[id]" value="<?=$v['item']['id']?>" /></td>
                    <td bgcolor="#FFFFFF"><textarea name="item[reply]" cols="68" rows="6" id="item[reply]"><?=$v['item']['reply']?></textarea></td>
                  </tr>
                  <tr>
                    <td valign="top" class="label">&nbsp;</td>
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
