<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$v['title']?></title>

<script src="scripts/myjs/base.js"></script>
<script src="scripts/myjs/gridview.js"></script>
<style type="text/css">
#perm_list{width:100%;height:420px;border:1px solid #eee;overflow:auto;}
</style>
<script language="javascript">
function cb_info_add(){
	alert('ok');
}
</script>
</head>
<body onLoad="Grid.init('data');">
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','系统用户分组');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                <?=$v['title']?>
              </h1>
        <div class="boxcontent">
                <table width="96%" border="0" cellpadding="2" cellspacing="1" class="tbox">
                  <tr>
                    <td width="120" align="right" valign="top" class="label"><input name="item[gid]" type="hidden" id="item[gid]" value="<?=$v['group']['id']?>" />
                      组名:</td>
                    <td bgcolor="#FFFFFF"><?=$v['group']['title']?></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" class="label">说明:</td>
                    <td bgcolor="#FFFFFF"><?=$v['group']['description']?></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" class="label">权限设置:</td>
                    <td bgcolor="#FFFFFF"><div id="perm_list">
                        <table id="data" width="100%" border="0" cellspacing="1" cellpadding="1">
                          <thead>
                            <tr bgcolor="#dbeaf5">
                              <td style="width:20px;height:22px">&nbsp;</td>
                              <td><strong>权限标识</strong></td>
                              <td><strong>权限说明</strong></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if(is_array($v['list']))foreach($v['list'] as $i): ?>
                            <tr>
                              <td><input name="id[]" id="id[]" type="checkbox" value="<?=$i['title']?>" <?=$i['check']?>/></td>
                              <td><?=$i['title']?></td>
                              <td><?=$i['description']?></td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                          <tfoot>
                            <tr bgcolor="#f0f8fe">
                              <td>↑</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                          </tfoot>
                          <tr>
                            <td colspan="3"><input name="check" type="button" id="check" class="btnCheck" value=" 反选 "/>
                                <input name="uncheck" type="button" id="uncheck" class="btnUncheck" value=" 取消选中 "/></td>
                          </tr>
                        </table>
                    </div></td>
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