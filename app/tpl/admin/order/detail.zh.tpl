<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$v['title']?></title>
<script src="scripts/utils.js"></script>
<style type="text/css">
<!--
.lt {	border-top: 1px solid #000000;
}
-->
</style>
</head>

<body>
<?php plugin('admin_header');?>
<form name="main_form" action="<?=$v['form_act'];?>" method="post">
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
          <table width="100%" border="0" cellpadding="4" cellspacing="1" class="tbox">
                  <tr>
                    <td class="label">订单号 ： </td>
                    <td bgcolor="#FFFFFF">&nbsp;<?=snFormat($v['item']['sn'])?></td>
                  </tr>
                  <tr>
                    <td class="label">订购清单：</td>
                    <td bgcolor="#FFFFFF"><table width="550" border="0" cellpadding="0" cellspacing="4">
                      <tr bgcolor="#fdf8fe">
                        <td width="20" align="center"><strong>NO. </strong></td>
                        <td><strong>款号</strong></td>
                        <td><strong>单价</strong></td>
                        <td><strong>数量</strong></td>
                        <td><strong>合计</strong></td>
                      </tr>
                      <?php for($i=0; $i < count($v['item']['list']); $i++):?>
                      <tr bgColor="<?php echo plugin('cycle', array('#f6f6f6','#fbfbfb'));?>">
                        <td align="center"><?=($i+1)?></td>
                        <td><?=$v['item']['list'][$i]['pd_sn'];?></td>
                        <td>￥<?=$v['item']['list'][$i]['price'];?></td>
                        <td><?=$v['item']['list'][$i]['quanlity'];?></td>
                        <td>￥<?=$v['item']['list'][$i]['count']?></td>
                      </tr>
					  <?php endfor; ?>
                      <tr>
                        <td colspan="5" align="right">总额：<?=$v['item']['total']?> x <?=$v['item']['discount']?> = ￥<?=($v['item']['total'] * $v['item']['discount'])?></td>
                      </tr>
                    </table>
                    <?=$v['emsg']['list']?></td>
                  </tr>
                  <tr>
                    <td class="label">订货区域：</td>
                    <td bgcolor="#FFFFFF">&nbsp;<?=$v['item']['area']?></td>
                  </tr>
                  <tr>
    <td class="label">收货人姓名：</td>
    <td bgcolor="#FFFFFF">&nbsp;<?=$v['item']['name']?></td>
  </tr>
  <tr>
    <td class="label">联系电话：</td>
    <td bgcolor="#FFFFFF">&nbsp;<?=$v['item']['phone']?></td>
  </tr>
  <tr>
    <td class="label">手机：</td>
    <td bgcolor="#FFFFFF">&nbsp;<?=$v['item']['mobile']?></td>
  </tr>
  <tr>
    <td class="label">电子邮箱：</td>
    <td bgcolor="#FFFFFF">&nbsp;<a href="mailto:<?=$v['item']['email']?>"><?=$v['item']['email']?></a></td>
  </tr>
  <tr>
    <td class="label">联系地址：</td>
    <td bgcolor="#FFFFFF">&nbsp;<?=$v['item']['addr']?></td>
  </tr>
  <tr>
    <td class="label">邮政编码：</td>
    <td bgcolor="#FFFFFF">&nbsp;<?=$v['item']['zip']?></td>
  </tr>
  <tr>
    <td class="label">补充说明：</td>
    <td bgcolor="#FFFFFF">&nbsp;<?=$v['item']['note']?></td>
  </tr>
  <tr>
    <td class="label">订购时间：</td>
    <td bgcolor="#FFFFFF">&nbsp;<?=$v['item']['put_time']?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>订购单处理情况</strong></td>
  </tr>
  <tr>
    <td class="label">订购单状态：</td>
    <td bgcolor="#FFFFFF"><?=$v['state']?></td>
  </tr>
  <?php if('已完成' == $v['state']): ?>
  <tr>
    <td class="label">处理结果：</td>
    <td bgcolor="#FFFFFF"><?=$v['item']['proc_result']?></td>
  </tr>
  <tr>
    <td class="label">操作者：</td>
    <td bgcolor="#FFFFFF"><?=$v['item']['handler']?></td>
  </tr>
  <tr>
    <td class="label">处理时间：</td>
    <td bgcolor="#FFFFFF"><?=$v['item']['proc_time']?></td>
  </tr>
  <?php endif;?>
                  <tr>
                    <td width="120" class="label">&nbsp;</td>
                    <td bgcolor="#FFFFFF"><input name="goback" type="button" id="goback" value=" 返回 " class="btn_b" onclick="location.replace('<?=$v['goback']?>');"/></td>
                  </tr>
            </table>
        </div>
        <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b> </div></td>
    </tr>
  </table>
</form>
</body>
</html>
