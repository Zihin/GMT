<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo SITE_NAME;?></title>
<style type="text/css">
<!--
.hdn{width:160px; position:static; height:20px; overflow:hidden; cursor:pointer;}
.sho{width:320px; position:absolute; background:#ffd; border:1px solid #fcc; padding:5px; cursor:pointer;}
-->
</style>
<script src="scripts/myjs/base.js"></script>
<script src="scripts/myjs/gridview.js"></script>
<script src="scripts/myjs/hidetext.js"></script>
</head>
<body onLoad="Grid.init('data');hidetext('data','hdn','sho');">
<?php plugin('admin_header');?><form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','类别管理');?><script language="javascript">var m = new Menu('menu');</script></td>
    <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onClick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
    <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
          <h1>
            <?=$v['title']?>
          </h1>
      <div class="boxcontent">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 5px">
              <tr>
                <td><?=$v['button']?></td>
              </tr>
            </table>
        <div style="background:url(imgs/sbar_bg.gif); border:1px solid #FCE6AA; padding:4px;margin-bottom:5px; text-align:right;">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left">当前位置:
                    <?=$v['nodepath']?></td>
                  <td align="right"><?=$v['btns']?>
                      <?=$v['expan']?>
                      <input name="kw_expan" type="hidden" id="kw_expan" value="<?=$v['kw']['kw_expan']?>" size="12" />
                      <input name="kw_pid" type="hidden" id="kw_pid" value="<?=$v['kw']['kw_pid']?>" size="12" /></td>
                </tr>
              </table>
        </div>
        <table id="data" width="100%" border="0" cellpadding="2" cellspacing="1" class="win_l" bgcolor="#FFFFFF">
              <thead>
                <tr bgcolor="#dbeaf5">
                  <td style="width:20px;">&nbsp;</td>
                  <td>ID</td>
                  <td>中文标题</td>
                  <td>英文标题</td>
                  <td width="40">子类别</td>
                  <td width="160">模板</td>
                  <td width="160">描述</td>
                  <td>操作</td>
                </tr>
              </thead>
              <tbody>
                <?php if(count($v['list'])): foreach($v['list'] as $i): ?>
                <tr>
                  <td><input name="id[]" id="id[]" type="checkbox" value="<?=$i['id']?>" /></td>
                  <td><?=$i['id']?></td>
                  <td><?=$i['title_zh']?></td>
                  <td><?=$i['title_en']?></td>
                  <td><?=$i['child_num']?></td>
                  <td valign="top"><div class="hdn"><?=$i['tpl_l']?> <?=$i['tpl_v']?></div></td>
                  <td valign="top"><div class="hdn"><?=$i['description']?></div></td>
                  <td><?=$i['btns']?></td>
                </tr>
                <?php endforeach;else: ?>
                <tr>
                  <td colspan="8" align="center">没有找到任何记录...</td>
                </tr>
                <?php endif; ?>
              </tbody>
              <tfoot>
                <tr bgcolor="#f0f8fe">
                  <td align="center">↑</td>
                  <td colspan="7" align="center"><?=$v['page_index'] //分页索引?></td>
                </tr>
                <tr>
                  <td colspan="8" align="left"><input name="check" type="button" id="check" class="btnCheck" value=" 反选 "/>
                      <input name="uncheck" type="button" id="uncheck" class="btnUncheck" value=" 取消选中 "/>
                    选中项:
                    <?=$v['mul_op']?></td>
                </tr>
              </tfoot>
            </table>
      </div>
      <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></div></td>
  </tr>
</table></form>
</body>
</html>