<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$v['title']?></title>

<script type="text/JavaScript" src="scripts/editor/js/dialogEditorShared.js"></script> 
<script type="text/javascript" src="scripts/editor.js"></script>

<style type="text/css">
@import url(scripts/calendar/calendar-system.css);
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
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','批量订购单');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                <?=$v['title']?>
              </h1>
        <div class="boxcontent">
          <table width="520" cellpadding="2" cellspacing="2" bgcolor="#f6f6f6">
            <tr>
              <td><strong>联 系 人:</strong>                <?=$v['item']['name']?></td>
            </tr>
            <tr>
              <td><strong>地　　址:</strong>
                <?=$v['item']['addr']?></td>
            </tr>
            <tr>
              <td><strong>联系电话:</strong>                <?=$v['item']['phone']?></td>
            </tr>
            <tr>
              <td><strong>手　　机:</strong>                <?=$v['item']['mobile']?></td>
            </tr>
            <tr>
              <td><strong>详细收货地址:</strong>                <?=$v['item']['direction']?></td>
            </tr>
            <tr>
              <td><strong>是否有指定承运单位:</strong>                <?=$v['item']['traffic']?></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
                  <tr bgcolor="#f4f4ff">
                    <td><strong>款号</strong></td>
                    <td><strong>颜色</strong></td>
                    <td><strong>M</strong></td>
                    <td><strong>L</strong></td>
                    <td><strong>XL</strong></td>
                    <td><strong>XXL</strong></td>
                    <td><strong>数量</strong></td>
                  </tr>
                  <tr bgcolor="#ffffff">
                    <td><?=$v['item']['list'][1]['sn']?></td>
                    <td><?=$v['item']['list'][1]['color']?></td>
                    <td><?=$v['item']['list'][1]['m']?></td>
                    <td><?=$v['item']['list'][1]['l']?></td>
                    <td><?=$v['item']['list'][1]['xl']?></td>
                    <td><?=$v['item']['list'][1]['xxl']?></td>
                    <td><?=$v['item']['list'][1]['quanlity']?></td>
                  </tr>
                  <tr>
                    <td><?=$v['item']['list'][2]['sn']?></td>
                    <td><?=$v['item']['list'][2]['color']?></td>
                    <td><?=$v['item']['list'][2]['m']?></td>
                    <td><?=$v['item']['list'][2]['l']?></td>
                    <td><?=$v['item']['list'][2]['xl']?></td>
                    <td><?=$v['item']['list'][2]['xxl']?></td>
                    <td><?=$v['item']['list'][2]['quanlity']?></td>
                  </tr>
                  <tr bgcolor="#ffffff">
                    <td><?=$v['item']['list'][3]['sn']?></td>
                    <td><?=$v['item']['list'][3]['color']?></td>
                    <td><?=$v['item']['list'][3]['m']?></td>
                    <td><?=$v['item']['list'][3]['l']?></td>
                    <td><?=$v['item']['list'][3]['xl']?></td>
                    <td><?=$v['item']['list'][3]['xxl']?></td>
                    <td><?=$v['item']['list'][3]['quanlity']?></td>
                  </tr>
                  <tr>
                    <td><?=$v['item']['list'][4]['sn']?></td>
                    <td><?=$v['item']['list'][4]['color']?></td>
                    <td><?=$v['item']['list'][4]['m']?></td>
                    <td><?=$v['item']['list'][4]['l']?></td>
                    <td><?=$v['item']['list'][4]['xl']?></td>
                    <td><?=$v['item']['list'][4]['xxl']?></td>
                    <td><?=$v['item']['list'][4]['quanlity']?></td>
                  </tr>
                  <tr bgcolor="#ffffff">
                    <td><?=$v['item']['list'][5]['sn']?></td>
                    <td><?=$v['item']['list'][5]['color']?></td>
                    <td><?=$v['item']['list'][5]['m']?></td>
                    <td><?=$v['item']['list'][5]['l']?></td>
                    <td><?=$v['item']['list'][5]['xl']?></td>
                    <td><?=$v['item']['list'][5]['xxl']?></td>
                    <td><?=$v['item']['list'][5]['quanlity']?></td>
                  </tr>
				  <tr bgcolor="#ffffff">
                    <td><?=$v['item']['list'][6]['sn']?></td>
                    <td><?=$v['item']['list'][6]['color']?></td>
                    <td><?=$v['item']['list'][6]['m']?></td>
                    <td><?=$v['item']['list'][6]['l']?></td>
                    <td><?=$v['item']['list'][6]['xl']?></td>
                    <td><?=$v['item']['list'][6]['xxl']?></td>
                    <td><?=$v['item']['list'][6]['quanlity']?></td>
                  </tr>
				  <tr bgcolor="#ffffff">
                    <td><?=$v['item']['list'][7]['sn']?></td>
                    <td><?=$v['item']['list'][7]['color']?></td>
                    <td><?=$v['item']['list'][7]['m']?></td>
                    <td><?=$v['item']['list'][7]['l']?></td>
                    <td><?=$v['item']['list'][7]['xl']?></td>
                    <td><?=$v['item']['list'][7]['xxl']?></td>
                    <td><?=$v['item']['list'][7]['quanlity']?></td>
                  </tr>
				  <tr bgcolor="#ffffff">
                    <td><?=$v['item']['list'][8]['sn']?></td>
                    <td><?=$v['item']['list'][8]['color']?></td>
                    <td><?=$v['item']['list'][8]['m']?></td>
                    <td><?=$v['item']['list'][8]['l']?></td>
                    <td><?=$v['item']['list'][8]['xl']?></td>
                    <td><?=$v['item']['list'][8]['xxl']?></td>
                    <td><?=$v['item']['list'][8]['quanlity']?></td>
                  </tr>
				  <tr bgcolor="#ffffff">
                    <td><?=$v['item']['list'][9]['sn']?></td>
                    <td><?=$v['item']['list'][9]['color']?></td>
                    <td><?=$v['item']['list'][9]['m']?></td>
                    <td><?=$v['item']['list'][9]['l']?></td>
                    <td><?=$v['item']['list'][9]['xl']?></td>
                    <td><?=$v['item']['list'][9]['xxl']?></td>
                    <td><?=$v['item']['list'][9]['quanlity']?></td>
                  </tr>
				  <tr bgcolor="#ffffff">
                    <td><?=$v['item']['list'][10]['sn']?></td>
                    <td><?=$v['item']['list'][10]['color']?></td>
                    <td><?=$v['item']['list'][10]['m']?></td>
                    <td><?=$v['item']['list'][10]['l']?></td>
                    <td><?=$v['item']['list'][10]['xl']?></td>
                    <td><?=$v['item']['list'][10]['xxl']?></td>
                    <td><?=$v['item']['list'][10]['quanlity']?></td>
                  </tr>
				  <tr bgcolor="#ffffff">
                    <td><?=$v['item']['list'][11]['sn']?></td>
                    <td><?=$v['item']['list'][11]['color']?></td>
                    <td><?=$v['item']['list'][11]['m']?></td>
                    <td><?=$v['item']['list'][11]['l']?></td>
                    <td><?=$v['item']['list'][11]['xl']?></td>
                    <td><?=$v['item']['list'][11]['xxl']?></td>
                    <td><?=$v['item']['list'][11]['quanlity']?></td>
                  </tr>
				  <tr bgcolor="#ffffff">
                    <td><?=$v['item']['list'][12]['sn']?></td>
                    <td><?=$v['item']['list'][12]['color']?></td>
                    <td><?=$v['item']['list'][12]['m']?></td>
                    <td><?=$v['item']['list'][12]['l']?></td>
                    <td><?=$v['item']['list'][12]['xl']?></td>
                    <td><?=$v['item']['list'][12]['xxl']?></td>
                    <td><?=$v['item']['list'][12]['quanlity']?></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><input name="goback" type="button" id="goback" value=" 返回 " class="btn_b" onclick="location.replace('<?=$v['goback']?>');"/></td>
            </tr>
          </table>
        </div>
        <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b> </div></td>
    </tr>
  </table>
</form>
</body>
</html>
