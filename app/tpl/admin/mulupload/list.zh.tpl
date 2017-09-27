<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$v['title']?></title>

<script src="scripts/utils.js"></script>
<script src="scripts/prototype.js"></script>
<script src="scripts/myjs/ulview.js"></script>
<style type="text/css">
#list{
  margin:0;padding:0;
  list-style:none;
  overflow:hidden;
}
#list li{
	width:140px;height:142px;
	margin:2px;padding:2px;
	float:left;
	border:1px solid #ddf;
}
</style>
<style type="text/css">@import url(scripts/calendar/calendar-system.css);</style>
<script type="text/javascript" src="scripts/calendar/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar/lang/calendar-zh.js"></script>
<script type="text/javascript" src="scripts/calendar/calendar-setup.js"></script>
</head>
<body onLoad="UlView.init('data');">
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','首页轮播广告');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                <?=$v['title']?>
              </h1>
        <div class="boxcontent">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><?=$v['button']?></td>
                  </tr>
                </table>
          <div style="background:url(imgs/sbar_bg.gif); border:1px solid #FCE6AA; padding:10px 5px 5px 5px;margin-bottom:5px; text-align:right;">
            </div>
          <table id="data" width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
                  <tbody>
                    <?php if(count($v['list'])):?>
                    <tr>
                      <td><ul id="list">
                          <?php foreach($v['list'] as $i): ?>
                          <li>
                            <table width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#f7f7f7">
                              <tr>
                                <td height="100" colspan="2" align="center"><img width="10" height="10" src="<?=$i['pic'];?>" align="absbottom" onload="resizeImg(this,130,100)"/></td>
                              </tr>
                              <tr bgcolor="#eeeeee">
                                <td colspan="2"><div style="height:20px;overflow:hidden;text-align:center">
                                    <?=$i['sn']?>
                                </div></td>
                              </tr>
                              <tr>
                                <td style="width:40px;"><input type="checkbox" id="id[]" name="id[]" value="<?=$i['id']?>" />
                                </td>
                                <td align="right"><?=$i['btns']?></td>
                              </tr>
                            </table>
                          </li>
                        <?php endforeach; ?>
                      </ul></td>
                    </tr>
                    <?php else:?>
                    <tr>
                      <td align="center">没有找到任何记录...</td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                  <tfoot>
                    <tr bgcolor="#f0f8fe">
                      <td align="center"><?=$v['page_index'] //分页索引?></td>
                    </tr>
                    <tr>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><input name="check" type="button" id="check" class="btnCheck" value=" 反选 "/>
                                <input name="uncheck" type="button" id="uncheck" class="btnUncheck" value=" 取消选中 "/>
                              选中项:
                              <?=$v['mul_op']?></td>
                            <td align="right">显示
                              <select name="row" onchange="if(<?=$v['kw']['row']?> != this.value)location.replace('<?=$v['form_act']?>,row,'+this.value);">
                                  <option value="<?=$v['kw']['row']?>">
                                  <?=$v['kw']['row']?>
                                  </option>
                                  <option value="" disabled="disabled">---</option>
                                  <option value="20">20</option>
                                  <option value="50">50</option>
                                  <option value="100">100</option>
                                </select>
                              个 </td>
                          </tr>
                      </table></td>
                    </tr>
                  </tfoot>
                </table>
        </div>
        <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b> </div></td>
    </tr>
  </table>
</form>
</body>
</html>
