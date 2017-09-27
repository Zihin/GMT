<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$v['title']?></title>
<script type="text/JavaScript" src="scripts/editor/js/dialogEditorShared.js"></script> 
<script type="text/javascript" src="scripts/editor.js"></script>
<script type="text/javascript" src="scripts/utils.js"></script>

</head>

<body>
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','查看会员列表');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                <?=$v['title']?>
              </h1>
        <div class="boxcontent">
                <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbox">
                  <tr>
                    <td width="120" class="label"><input name="item[id]" type="hidden" id="item[id]" value="<?=$v['item']['id']?>" />
                      是否激活:</td>
                    <td bgcolor="#FFFFFF"><?=$v['item']['actived']?>
                        <span class="red">*</span>
                        <?=$v['emsg']['actived']?></td>
                  </tr>
                  <tr>
                    <td class="label"> 登录名:</td>
                    <td bgcolor="#FFFFFF"><input name="item[username]" type="text" id="item[username]" value="<?=$v['item']['username']?>" />
                        <span class="red">*</span>
                        <?=$v['emsg']['username']?></td>
                  </tr>
                  <tr>
                    <td class="label">用户组:</td>
                    <td bgcolor="#FFFFFF"><?=$v['item']['gid']?>
                        <span class="red">*</span>
                        <?=$v['emsg']['gid']?></td>
                  </tr>
                  <tr>
                    <td class="label">会员编号</td>
                    <td bgcolor="#FFFFFF"><?=$v['item']['member_code']?></td>
                  </tr>
                  <tr>
                    <td class="label">密码:</td>
                    <td bgcolor="#FFFFFF"><input name="item[passwd]" type="text" id="item[passwd]" />
                        <?=$v['emsg']['passwd']?></td>
                  </tr>
                  <tr>
                    <td class="label">确认密码:</td>
                    <td bgcolor="#FFFFFF"><input name="item[passwd1]" type="text" id="item[passwd1]" />
                        <?=$v['emsg']['passwd1']?></td>
                  </tr>
                  <tr>
                    <td class="label">真实姓名:</td>
                    <td bgcolor="#FFFFFF"><input name="item[name]" type="text" id="item[name]" value="<?=$v['item']['name']?>" /></td>
                  </tr>
                  <tr>
                    <td class="label">性别:</td>
                    <td bgcolor="#FFFFFF">
                      <?=$v['item']['sex']?>
                      <span class="red">*</span>
                      <?=$v['emsg']['sex']?></td>
                  </tr>
                  <tr>
                    <td class="label">联系电话</td>
                    <td bgcolor="#FFFFFF"><input name="item[phone]" type="text" id="item[phone]" value="<?=$v['item']['phone']?>" /></td>
                  </tr>

                    <tr>
                        <td class="label">积分</td>
                        <td bgcolor="#FFFFFF"><input name="item[points]" type="text" id="item[points]" value="<?=$v['item']['points']?>" /></td>
                    </tr>

                    <?
                    if($v['item']['is_apply'] > 0){
                    ?>
                    <tr>
                        <td  colspan="2"><h1>升级资料</h1></td>
                    </tr>
                    <tr>
                        <td class="label">姓名</td>
                        <td bgcolor="#FFFFFF"><input name="item[name]" type="text" id="item[points]" value="<?=$v['item']['name']?>" /></td>
                    </tr>
                    <tr>
                        <td class="label">手机</td>
                        <td bgcolor="#FFFFFF"><input name="item[mobile]" type="text" id="item[points]" value="<?=$v['item']['mobile']?>" /></td>
                    </tr>
                    <tr>
                        <td class="label">证件照片</td>
                        <td bgcolor="#FFFFFF">
                            
                        <input name="item[photo]" type="text" id="item[photo]" value="<?=$v['item']['photo']?>" />
                        <input onclick="openImageWindow('insertImg','img_preview1','item[photo]')" type="button" name="imgBrowse" value="选择图片" />
                        <div id="img_preview1" style="width:120px;height:120px;border:1px solid #eef;">
                        <?=$v['item']['preview']?>
                      </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">毕业证书扫描件</td>
                        <td bgcolor="#FFFFFF">
                            
                        <input name="item[certificate_img]" type="text" id="item[certificate_img]" value="<?=$v['item']['certificate_img']?>" />
                        <input onclick="openImageWindow('insertImg','img_preview2','item[certificate_img]')" type="button" name="imgBrowse" value="选择图片" />
                        <div id="img_preview2" style="width:120px;height:120px;border:1px solid #eef;">
                        <?=$v['item']['preview2']?>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">身份证正面扫描件</td>
                        <td bgcolor="#FFFFFF">
                            
                        <input name="item[card_img1]" type="text" id="item[card_img1]" value="<?=$v['item']['card_img1']?>" />
                        <input onclick="openImageWindow('insertImg','img_preview3','item[card_img1]')" type="button" name="imgBrowse" value="选择图片" />
                        <div id="img_preview3" style="width:120px;height:120px;border:1px solid #eef;">
                        <?=$v['item']['preview3']?>
                        </div></td>
                    </tr>
                    <tr>
                        <td class="label">身份证反面扫描件</td>
                        <td bgcolor="#FFFFFF">
                        <input name="item[card_img2]" type="text" id="item[card_img2]" value="<?=$v['item']['card_img2']?>" />
                        <input onclick="openImageWindow('insertImg','img_preview4','item[card_img2]')" type="button" name="imgBrowse" value="选择图片" />
                        <div id="img_preview4" style="width:120px;height:120px;border:1px solid #eef;">
                        <?=$v['item']['preview4']?>
                        </div></td>
                    </tr>
                    <tr>
                        <td class="label">审核状态</td>
                        <td bgcolor="#FFFFFF">
                            <input id="sex0" name="item[is_apply]" type="radio" value="2" <?=$v['item']['is_apply']==2?"checked=\"checked\"":""?>>通过
                            <input id="sex0" name="item[is_apply]" type="radio" value="3" <?=$v['item']['is_apply']==3?"checked=\"checked\"":""?>>不通过</td>
                    </tr>
                    <?
                    }
                    ?>
                  <tr>
                    <td class="label">&nbsp;</td>
                    <td bgcolor="#FFFFFF"><input name="submit" type="submit" id="submit" value=" 提交 " class="btn_b" />
                        <input name="goback" type="button" id="goback" value=" 返回 " class="btn_b" onclick="location.replace('<?=$v['goback']?>');"/></td>
                  </tr>
                </table>
        </div>
        <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b> </div></td>
    </tr>
  </table>
</form>
</body>
</html>
