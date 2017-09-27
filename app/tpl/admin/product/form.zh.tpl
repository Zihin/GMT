<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$v['title']?></title>

<script type="text/JavaScript" src="scripts/editor/js/dialogEditorShared.js"></script> 
<script type="text/javascript" src="scripts/editor.js"></script>
<script type="text/javascript" src="scripts/utils.js"></script>

<style type="text/css">@import url(scripts/calendar/calendar-system.css);</style>
<script type="text/javascript" src="scripts/calendar/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar/lang/calendar-zh.js"></script>
<script type="text/javascript" src="scripts/calendar/calendar-setup.js"></script>

</head>

<body>
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','发布产品');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                <?=$v['title']?>
              </h1>
        <div class="boxcontent">
                <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbox">
                  <tr>
                    <td width="120" class="label">款号:
                    <input name="item[id]" type="hidden" id="item[id]" value="<?=$v['item']['id']?>" /></td>
                    <td bgcolor="#FFFFFF"><input name="item[sn]" type="text" id="item[sn]" value="<?=$v['item']['sn']?>" /> 
                      <span class="red">*</span>
                      <?=$v['emsg']['sn']?></td>
                  </tr>
                  <tr>
                    <td class="label">类别:</td>
                    <td bgcolor="#FFFFFF"><?=$v['item']['cate']?>
                        <span class="red">*</span>
                        <?=$v['emsg']['cate']?></td>
                  </tr>
                  <tr>
                    <td class="label">产品图片:</td>
                    <td bgcolor="#FFFFFF"><div id="img_preview" style="width:120px;height:120px;border:1px solid #eef;">
                        <?=$v['item']['preview']?>
                      </div>
                        <input name="item[pic]" type="text" id="item[pic]" value="<?=$v['item']['pic']?>" />
                        <input onclick="openImageWindow('insertImg')" type="button" name="imgBrowse" value="选择图片" />
                        <span class="red">*</span>
                        <?=$v['emsg']['pic']?></td>
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
