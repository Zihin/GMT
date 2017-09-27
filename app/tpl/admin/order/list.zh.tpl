<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$v['title']?></title>

<script src="scripts/utils.js"></script>
<script src="scripts/myjs/base.js"></script>
<script src="scripts/myjs/gridview.js"></script>
<style type="text/css">
@import url(scripts/calendar/calendar-system.css);
</style>
<script type="text/javascript" src="scripts/calendar/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar/lang/calendar-zh.js"></script>
<script type="text/javascript" src="scripts/calendar/calendar-setup.js"></script>
</head>
<body onLoad="Grid.init('data');">
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','网上订单处理');?>
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
          <div style="background:url(imgs/sbar_bg.gif); border:1px solid #FCE6AA; padding:5px;margin-bottom:5px; text-align:right; line-height:24px;"> 订单状态:
              <?=$v['state']?>
              订单号:
              <input name="sn" type="text" id="sn" value="<?=$v['kw']['sn']?>" size="16" />
              订购者:
              <input name="name" type="text" id="name" value="<?=$v['kw']['name']?>" size="16" />
              <br />

订购时间:
<input name="kw_start_time" type="text" id="kw_start_time" value="<?=$v['kw']['kw_start_time']?>" size="10"/>
            <img src="scripts/calendar/img.gif" name="trigger_time1" align="absmiddle" id="trigger_time1" style="cursor: pointer; border: 1px solid red;" title="选择日期" />
            <script type="text/javascript">
Calendar.setup({
	inputField     :    "kw_start_time",
	ifFormat       :    "%Y-%m-%d",
	button         :    "trigger_time1",
	singleClick    :    true
    });
          </script>
            到
            <input name="kw_end_time" type="text" id="kw_end_time" value="<?=$v['kw']['kw_end_time']?>" size="10" />
            <img src="scripts/calendar/img.gif" name="trigger_time2" align="absmiddle" id="trigger_time2" style="cursor: pointer; border: 1px solid red;" title="选择日期" />
            <script type="text/javascript">
Calendar.setup({
	inputField     :    "kw_end_time",
	ifFormat       :    "%Y-%m-%d",
	button         :    "trigger_time2",
	singleClick    :    true
    });
          </script>
            <span style="background:url(imgs/sbar_bg.gif); border:1px solid #FCE6AA; padding:3px 2px 2px 2px;margin-bottom:5px; text-align:right;">
            <input type="submit" name="search" value="按条件查找" style="height:26px;width:90px;"/>
            </span><img src="imgs/icon/t.gif" title="如果你想查看特定的项目,请输入相应的关键字进行查找" alt="" width="20" height="20" align="absmiddle" /></div>
          <table id="data" width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
                  <thead>
                    <tr bgcolor="#dbeaf5">
                      <td style="width:20px;">&nbsp;</td>
                      <td style="width:20px;">&nbsp;</td>
                      <td>订单号</td>
                      <td>所在区域</td>
                      <td>订购者</td>
                      <td>电话</td>
                      <td>电子邮箱</td>
                      <td>订购时间</td>
                      <td width="120">操作</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(count($v['list'])): foreach($v['list'] as $i): ?>
                    <tr>
                      <td><input name="sn[]" id="sn[]" type="checkbox" value="<?=$i['sn']?>" /></td>
                      <td><span style="width:40px;">
                        <?= ('-1'==$i['state']? '<img src="imgs/icon/uncheck.gif" title="已撤消">': ('1' == $i['state'] ?  '<img src="imgs/icon/check.gif" title="已完成">' : '<img src="imgs/icon/uncheck1.gif" title="未处理">'));?>
                      </span></td>
                      <td><?=snFormat($i['sn'])?></td>
                      <td><?=$i['area']?></td>
                      <td><?=$i['name']?></td>
                      <td><?=$i['phone']?></td>
                      <td><?=$i['email']?></td>
                      <td><?=$i['put_time']?></td>
                      <td><?=$i['btns']?></td>
                    </tr>
                    <?php endforeach;else: ?>
                    <tr>
                      <td colspan="9" align="center">没有找到任何记录...</td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                  <tfoot>
                    <tr bgcolor="#f0f8fe">
                      <td colspan="2" align="center">↑</td>
                      <td colspan="7" align="center"><?=$v['page_index'] //分页索引?></td>
                    </tr>
                    <tr>
                      <td colspan="9" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                              行 </td>
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
