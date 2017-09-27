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
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','查看会员列表');?>
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
          <div style="background:url(imgs/sbar_bg.gif); border:1px solid #FCE6AA; padding:3px 2px 2px 2px;margin-bottom:5px; text-align:right;"><img src="imgs/icon/t.gif" title="如果你想查看特定的帐号,请输入相应的关键字进行查找" alt="" width="20" height="20" align="absmiddle" /> 会员组:
            <?=$v['group_sel']?>
            登录名
            <input name="kw_username" type="text" id="kw_username" value="<?=$v['kw']['kw_username']?>" size="12" />
            会员编号
            <input name="kw_member_code" type="text" id="kw_member_code" value="<?=$v['kw']['kw_member_code']?>" size="16" />            
            发布时间:
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
            审核状态
            <select id="kw_is_apply" name="kw_is_apply">
                <option value=""></option>
                <option value="1">未审核</option>
                <option value="2">通过审核</option>
                <option value="3">未通过审核</option>
            </select>
            <input type="submit" name="search" value="按条件查找" style="height:26px;width:90px;"/>
            </div>
          <table id="data" width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
                  <thead>
                    <tr bgcolor="#dbeaf5">
                      <td style="width:20px;">&nbsp;</td>
                      <td style="width:20px;">&nbsp;</td>
                      <td>登录名</td>
                      <td>会员编号</td>
					  <td>姓名</td>
					  <td>性别(1女0男)</td>
					  <td>联系电话</td>
                      <td>所属组</td>
                      <td>积分</td>
                      <td>注册时间</td>
                      <td>操作</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(count($v['list'])): foreach($v['list'] as $i): ?>
                    <tr>
                      <td><input name="id[]" id="id[]" type="checkbox" value="<?=$i['id']?>" /></td>
                      <td><?=$i['actived']?></td>
                      <td><?=$i['username']?></td>
                      <td><?=$i['member_code']?></td>
                      <td><?=$i['name']?></td>
                      <td><?=$i['sex']?></td>
                      <td><?=$i['phone']?></td>
                      <td><?=$i['gid']?></td>
                      <td><?=$i['points']?></td>
                      <td><?=$i['reg_date']?></td>
                      <td><?=$i['btns']?></td>
                    </tr>
                    <?php endforeach;else: ?>
                    <tr>
                      <td colspan="7" align="center">没有找到任何记录...</td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                  <tfoot>
                    <tr bgcolor="#f0f8fe">
                      <td align="center">↑</td>
                      <td colspan="6" align="center"><?=$v['page_index'] //分页索引?></td>
                    </tr>
                    <tr>
                      <td colspan="7" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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