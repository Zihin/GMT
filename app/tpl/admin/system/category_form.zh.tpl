<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo SITE_NAME;?></title>
<body>
<?php plugin('admin_header');?><form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','添加新类别');?><script language="javascript">var m = new Menu('menu');</script></td>
    <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onClick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
    <td valign="top">
      <div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
          <h1>
            <?=$v['title']?>
          </h1>
        <div class="boxcontent">
            <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbox">
              <tr>
                <td align="right" valign="top" class="label">父类别:</td>
                <td bgcolor="#FFFFFF"><?=$v['path']?></td>
              </tr>
              <tr>
                <td width="120" align="right" valign="top" class="label"><input name="item[id]" type="hidden" id="item[id]" value="<?=$v['item']['id']?>" />
                    <input name="item[pid]" type="hidden" id="item[pid]" value="<?=$v['item']['pid']?>" />
                  中文标题:</td>
                <td bgcolor="#FFFFFF"><input name="item[title_zh]" type="text" id="item[title_zh]" value="<?=$v['item']['title_zh']?>" size="30" maxlength="30" />
                    <span class="red">*</span>
                    <?=$v['emsg']['title_zh']?></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="label">英文标题:</td>
                <td bgcolor="#FFFFFF"><input name="item[title_en]" type="text" id="item[title_en]" value="<?=$v['item']['title_en']?>" size="30" maxlength="30">
                  <span class="red">*</span>
                  <?=$v['emsg']['title_en']?></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="label">信息容量:</td>
                <td bgcolor="#FFFFFF"><span class="tips">限制同类信息数量,发布的信息不允许超过设定的条数.留空(或设为'0')则不限制</span> <br />
                    <input name="item[max_num]" type="text" id="item[max_num]" value="<?=$v['item']['max_num']?>" />
                    <?=$v['emsg']['max_num']?></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="label">列表模板:</td>
                <td bgcolor="#FFFFFF"><span class="tips">该类别的信息使用指定的模板进行列表显示,留空则使用父类别的设置.(该设置可以被下级设置覆盖)</span><br />
                    <input name="item[tpl_l]" type="text" id="item[tpl_l]" value="<?=$v['item']['tpl_l']?>" size="56" />
                    <?=$v['emsg']['tpl_l']?></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="label">显示模板:</td>
                <td bgcolor="#FFFFFF"><span class="tips">该类别的信息使用指定的模板显示详细内容,留空则使用父类别的设置.(该设置可以被下级设置覆盖)</span><br />
                    <input name="item[tpl_v]" type="text" id="item[tpl_v]" value="<?=$v['item']['tpl_v']?>" size="56" />
                    <?=$v['emsg']['tpl_d']?></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="label">说明:</td>
                <td bgcolor="#FFFFFF"><textarea name="item[description]" cols="64" rows="6" id="item[description]"><?=$v['item']['description']?></textarea></td>
              </tr>
              <tr>
                <td valign="top" class="label">&nbsp;</td>
                <td bgcolor="#FFFFFF"><input name="submit" type="submit" id="submit" value=" 提交 " class="btn_b" />
                    <input name="goback" type="button" id="goback" value=" 返回 " class="btn_b" onClick="location.replace('<?=$v['goback']?>');"/></td>
              </tr>
            </table>
        </div>
        <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b> </div>
    </td>
  </tr>
</table></form>
</body>
</html>