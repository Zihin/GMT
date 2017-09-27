<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$v['title']?></title>

</head>
<body>
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','考生信息列表');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                考生信息详情
              </h1>
        <div class="boxcontent">
                <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbox">
                  <tr>
                    <td width="120" align="right" valign="top" class="label">姓氏:</td>
                    <td bgcolor="#FFFFFF"><?=$v['sure_name']?></td>
                  </tr>
                    <tr>
                    <td width="120" align="right" valign="top" class="label">名字:</td>
                    <td bgcolor="#FFFFFF"><?=$v['given_name']?></td>
                    </tr>
                  <tr>
                    <td align="right" valign="top" class="label">中文姓名:</td>
                    <td bgcolor="#FFFFFF"><?=$v['ch_name']?></td>
                  </tr>
                    <tr>
                        <td align="right" valign="top" class="label">出生日期:</td>
                        <td bgcolor="#FFFFFF"><?=$v['birthday']?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">性别:</td>
                        <td bgcolor="#FFFFFF"><?=$v['gender'] == 1? '女' : '男'?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">身份证/护照号码:</td>
                        <td bgcolor="#FFFFFF"><?=$v['passport_no']?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">国籍:</td>
                        <td bgcolor="#FFFFFF"><?=$v['nationality']?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">电话号码:</td>
                        <td bgcolor="#FFFFFF"><?=$v['tel']?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">邮箱:</td>
                        <td bgcolor="#FFFFFF"><?=$v['email']?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">联系地址:</td>
                        <td bgcolor="#FFFFFF"><?=$v['address']?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">快递证书:</td>
                        <td bgcolor="#FFFFFF"><?=$v['is_express']==1?'是':'否'?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">是否需要翻译:</td>
                        <td bgcolor="#FFFFFF"><?=$v['is_interpreter']==1?'是':'否'?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">上传考生报名照:</td>
                        <td bgcolor="#FFFFFF"><img  src="uploads/<?=$v['photo']?>" width="148" height="90"/></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">上传考生护照/身份证/
                            出生证明/户口本:</td>
                        <td bgcolor="#FFFFFF"><img  src="uploads/<?=$v['passport_img1']?>" width="148" height="90"/></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">上传考生身份证反面:</td>
                        <td bgcolor="#FFFFFF">  <img  src="uploads/<?=$v['passport_img2']?>" width="148" height="90"/></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="label">录入时间:</td>
                        <td bgcolor="#FFFFFF"> <?=$v['put_time']?></td>
                    </tr>
                </table>
        </div>
        <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b> </div></td>
    </tr>
  </table>
</form>
</body>
</html>
