<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>报考信息打印</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta http-equiv="Expires" CONTENT="0">
  <meta http-equiv="Cache-Control" CONTENT="no-cache">
  <meta http-equiv="Cache-Control" CONTENT="no-store">
  <link rel="stylesheet" href="css/gmt.css" type="text/css" />
  <style media="print">
    .Noprint{display: none;}
  </style>
  <style>
    .ptb{width:950px; border:0px;}
    .ptb td{text-align:left; width:50%;}
    .ptline{height:2px;border-bottom:1px #333 solid;}
  </style>
</head>
<body>
<center>
  <p>&nbsp;</p>
  <table class="ptb">
    <tr>
      <td width="50%"><img src="images/logo.png"></td>
      <td style="text-align:right" valign="bottom">报考编号 <span class="red"><?=$v['test']['test_no']?></span></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><div class="ptline"></div><div class="ptline"></div></td>
    </tr>
  </table>

  <table class="ptb">
    <tr>
      <td width="50%"><h3><b>考生信息</b></h3></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>姓名：<?=$v['candidate']['sure_name']?>&nbsp;<?=$v['candidate']['given_name']?></td>
      <td>性别：<?=$v['candidate']['gender']?></td>
    </tr>
    <tr>
      <td>身份证/护照号码：<?=$v['candidate']['passport_no']?></td>
      <td>电话号码：<?=$v['candidate']['tel']?></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><div class="ptline"></div></td>
    </tr>
  </table>

  <table class="ptb">
    <tr>
      <td width="50%"><h3><b>考试信息</b></h3></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>考试中心：<?=$v['test']['test_center']?></td>
      <td>科目：<?=$v['test']['subject']?> </td>
    </tr>
    <tr>
      <td>级别：<?=$v['test']['grade']?></td>
      <td>确认考试时间：<?=$v['test']['test_time']?></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><div class="ptline"></div></td>
    </tr>
  </table>

  <table class="ptb">
    <tr>
      <td width="50%"><h3><b>会员信息</b></h3></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>会员编号：  <?=$v['member']['member_code']?></td>
      <td>会员类型：  <?=$v['member']['gid']?></td>
    </tr>
    <tr>
      <td>姓名：<?=$v['member']['name']?></td>
      <td>电话号码：<?=$v['member']['mobile']?></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><div class="ptline"></div></td>
    </tr>
  </table>
  <p class="Noprint"><br><input type="button" value="打印表格" onClick="javascript:window.print()"/></p>
</center>
</body>
</html>