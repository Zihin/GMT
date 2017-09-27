<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单打印</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
}
.lb {
	border-bottom: 1px solid #000000;
}
.lt {
	border-top: 1px solid #000000;
}

-->
</style></head>

<body onload="try{wb.execwb(8,1);wb.execwb(7,1);}catch(e){print();}">
<table width="620" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td colspan="7" align="center"><span style="font: bold 18px/150% '宋体'">网上订单</span></td>
  </tr>
  <tr>
    <td colspan="7" class="lb"><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td colspan="2"><span class="label">单号:</span>
            <?=snFormat($v['item']['sn'])?></td>
        <td colspan="5" align="right">操作员:
          <?=$this->sess->get('username');?>
          日期:
          <?=$v['item']['put_time']?></td>
      </tr>
      <?php for($i=0; $i < count($v['item']['list']); $i++):?>
      <?php endfor; ?>
    </table></td>
  </tr>
  <tr>
    <td width="33" align="center" class="lb">No. </td>
    <td width="103" class="lb">款号</td>
    <td width="102" class="lb">颜色</td>
    <td width="99" class="lb">码数</td>
    <td width="97" class="lb">单价</td>
    <td width="64" class="lb">数量</td>
    <td width="94" class="lb">合计</td>
  </tr>
  <?php for($i=0; $i < count($v['item']['list']); $i++):?>
  <tr>
    <td align="center"><?=($i+1)?></td>
    <td><?=$v['item']['list'][$i]['pd_sn'];?></td>
    <td><?=$v['item']['list'][$i]['color'];?></td>
    <td><?=$v['item']['list'][$i]['size'];?></td>
    <td><?=$v['item']['list'][$i]['price'];?></td>
    <td><?=$v['item']['list'][$i]['quanlity'];?></td>
    <td>￥
      <?=$v['item']['list'][$i]['count']?></td>
  </tr>
  <?php endfor; ?>
  <tr>
    <td colspan="6" align="right" class="lt">折扣:<?=$v['item']['discount']?>&nbsp;&nbsp;&nbsp;&nbsp;总额：<?=$v['item']['total']?> x <?=$v['item']['discount']?> = </td>
    <td align="left" class="lt">￥<?=($v['item']['total'] * $v['item']['discount'])?></td>
  </tr>
</table>
<table width="620" border="0" cellpadding="4" cellspacing="0">
  <?php for($i=0; $i < count($v['item']['list']); $i++):?>
  <?php endfor; ?>
  <tr>
    <td align="right">订 购 人: </td>
    <td class="lb">      <?=$v['item']['name']?>    </td>
    <td width="72" align="right">手　　机:</td>
    <td class="lb">      <?=$v['item']['mobile']?>    </td>
  </tr>
  <tr>
    <td width="73" align="right">电　　话:</td>
    <td width="253" class="lb">      <?=$v['item']['phone']?>    </td>
    <td align="right">邮　　箱:</td>
    <td width="190" class="lb"><?=$v['item']['email']?></td>
  </tr>
  <tr>
    <td align="right">地　　址:</td>
    <td colspan="3" class="lb">      <?=$v['item']['addr'] ?>    </td>
  </tr>
  <tr>
    <td align="right">备　　注:</td>
    <td colspan="3" class="lb">      <?=$v['item']['note']?>    </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="3" align="right">　　广州箩伦诗服饰有限公司　　电话:020-34295256　　地址: 广州海珠区东晓路雅敦街4号304</td>
  </tr>
</table>
<OBJECT id=wb height=0 width=0
classid=CLSID:8856F961-340A-11D0-A96B-00C04FD705A2 name=wb></OBJECT>
</body>
</html>
