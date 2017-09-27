<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITE_NAME;?></title>

<script src="scripts/utils.js"></script>
<script src="scripts/myjs/base.js"></script>
<script src="scripts/myjs/gridview.js"></script>
<style type="text/css">
@import url(scripts/calendar/calendar-system.css);
.subject {font:bold 14px "宋体";
	line-height:22px;
}
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
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','客户留言管理');?>
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
          <div style="background:url(imgs/sbar_bg.gif); border:1px solid #FCE6AA; padding:2px;margin-bottom:5px; text-align:right;">主题:
            <input name="kw_subject" type="text" id="kw_subject" value="<?=$v['kw']['kw_subject']?>" size="24" />
            留言者:
            <input name="kw_name" type="text" id="kw_name" value="<?=$v['kw']['kw_name']?>" size="12" />
        
            <input type="submit" name="search" value="查找" />
            </div>
          <table id="data" width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
                  <thead>
                    <tr bgcolor="#dbeaf5">
                      <td style="width:20px;">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(count($v['list'])): foreach($v['list'] as $i): ?>
                    <tr>
                      <td><input name="id[]" id="id[]" type="checkbox" value="<?=$i['id']?>" /></td>
                      <td><span style="width:40px;">
                        <?//= ('1' == $i['state'] ?  '<img src="imgs/icon/check.gif" title="已公开">' : '<img src="imgs/icon/uncheck.gif" title="未公开">');?>
                      </span></td>
                      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="border:1px solid #eef;">
                        <tr bgcolor="#dbeaf5">
                          <td bgcolor="#dbeaf5" class="subject"></td>
                          <td width="10%" align="right"><?=$i['btns']?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                              <tr>
                                <td width="120" rowspan="2" align="center" bgcolor="#fafafa">
                                    <br />
                                    <?=$i['put_time']?></td>
                                <td valign="top"><?=$i['content']?>
                                    
                                    <br />
                                   联系地址
                                    <b>
                                    <?=$i['g_addr']?>
                                    </b>
                                   邮编
                                    <b>
                                    <?=$i['g_postcode']?>
                                    </b>
                                    <div align="right" style="font-weight:bold"></div></td>
                              </tr>
                              <tr>
                                <td height="20">
                                    <b>电子邮箱:</b> <a href="mailto:<?=$i['g_email']?>">
                                  <?=$i['g_email']?></a>
                                        <b>电话号码:</b> 
                                  <?=$i['g_phone']?>
                                        <b>来源:</b> 
                                  <?=$i['g_know']?>
                                
                              </tr>
                              <?php if($i['reply']):?>
                              <tr bgcolor="#f9f9f4">
                                <td align="center"><img src="imgs/master.gif" /><br />
                                  管理员<br />
                                  <?=$i['reply_time']?></td>
                                <td valign="top"><?=$i['reply']?></td>
                              </tr>
                              <?php endif; ?>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                    <?php endforeach;else: ?>
                    <tr>
                      <td colspan="3" align="center">没有找到任何记录...</td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                  <tfoot>
                    <tr bgcolor="#f0f8fe">
                      <td align="center">↑</td>
                      <td colspan="2" align="center"><?=$v['page_index'] //分页索引?></td>
                    </tr>
                    <tr>
                      <td colspan="3" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><input name="check" type="button" id="check" class="btnCheck" value=" 反选 "/>
                                <input name="uncheck" type="button" id="uncheck" class="btnUncheck" value=" 取消选中 "/>
                     </td>
                            <td align="right">显示
                              <select name="row" onchange="if(<?=$v['kw']['row']?> != this.value)location.replace('<?=$v['form_act']?>,row,'+this.value);">
                                  <option value="<?=$v['kw']['row']?>">
                                  <?=$v['kw']['row']?>
                                  </option>
                                  <option value="" disabled="disabled">---</option>
                                  <option value="5">5</option>
                                  <option value="10">10</option>
                                  <option value="30">30</option>
                                  <option value="50">50</option>
                                </select>
                              行 </td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td colspan="3" align="center">说明:客户提交的留言默认是不对外公开的,如果你希望对外公开,可通过改变留言的发布状态实现.</td>
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
