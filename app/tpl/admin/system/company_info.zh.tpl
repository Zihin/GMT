<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$v['title']?></title>

<script type="text/JavaScript" src="scripts/editor/js/dialogEditorShared.js"></script> 
<script type="text/javascript" src="scripts/editor.js"></script>
<script type="text/javascript" src="scripts/utils.js"></script>

<style type="text/css">@import url(scripts/calendar/calendar-system.css);</style>
<script type="text/javascript" src="scripts/calendar/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar/lang/calendar-zh.js"></script>
<script type="text/javascript" src="scripts/calendar/calendar-setup.js"></script>
<!--添加CK编辑器-->
<script src="scripts/ckeditor/ckeditor.js"></script>

</head>

<body>
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','基本信息维护');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                <?=$v['title']?>
              </h1>
        <div class="boxcontent">
                <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbox">
                  <tr>
                    <td width="120" class="label"> 公司名称:
                    <input name="item[id]" type="hidden" id="item[id]" value="<?=$v['item']['id']?>" /></td>
                    <td bgcolor="#FFFFFF"><input name="item[company_name]" type="text" id="item[company_name]" value="<?=$v['item']['company_name']?>" size="72" /></td>
                  </tr>
                  <tr>
                    <td class="label">LOGO图片:</td>
                    <td bgcolor="#FFFFFF"><div id="img_preview" style="width:120px;height:120px;border:1px solid #eef;">
                        <?=$v['item']['preview']?>
                      </div>
                        <input name="item[pic]" type="text" id="item[pic]" value="<?=$v['item']['pic']?>" />
                        <input onclick="openImageWindow('insertImg','img_preview','item[pic]')" type="button" name="imgBrowse" value="选择图片" />
                        <span class="red">*</span>
                        <?=$v['emsg']['pic']?></td>
                  </tr>
                  <tr>
                    <td class="label">公司介绍:</td>
                    <td bgcolor="#FFFFFF">
                        <span class="tips">详细信息显示的公司介绍</span><br/>
                        <textarea name="item[company_detail]" cols="72" rows="12" id="item[company_detail]"><?=$v['item']['company_detail']?></textarea>
                        <script type="text/javascript">
 
                        // 启用 CKEitor 的上传功能，使用了 CKFinder 插件

                        CKEDITOR.replace( 'item[company_detail]', {

                        filebrowserBrowseUrl : 'scripts/ckfinder/ckfinder.html',

                        filebrowserImageBrowseUrl : 'scripts/ckfinder/ckfinder.html?Type=Images',

                        filebrowserFlashBrowseUrl : 'scripts/ckfinder/ckfinder.html?Type=Flash',

                        filebrowserUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

                        filebrowserImageUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

                        filebrowserFlashUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

                        });

                        </script></td>
                  </tr>
                  <tr>
                    <td class="label">公司微信:</td>
                    <td bgcolor="#FFFFFF">
                        <span class="tips">底部显示的公司微信内容</span><br/>
                        <textarea name="item[company_intro]" cols="72" rows="12" id="item[company_intro]"><?=$v['item']['company_intro']?></textarea>
                        <script type="text/javascript">
 
                        // 启用 CKEitor 的上传功能，使用了 CKFinder 插件

                        CKEDITOR.replace( 'item[company_intro]', {

                        filebrowserBrowseUrl : 'scripts/ckfinder/ckfinder.html',

                        filebrowserImageBrowseUrl : 'scripts/ckfinder/ckfinder.html?Type=Images',

                        filebrowserFlashBrowseUrl : 'scripts/ckfinder/ckfinder.html?Type=Flash',

                        filebrowserUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

                        filebrowserImageUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

                        filebrowserFlashUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

                        });

                        </script></td>
                  </tr>
                  <tr>
                    <td class="label">联系我们:</td>
                    <td bgcolor="#FFFFFF">
                        <textarea name="item[contact]" cols="72" rows="12" id="item[contact]"><?=$v['item']['contact']?></textarea>
                        <script type="text/javascript">
 
                        // 启用 CKEitor 的上传功能，使用了 CKFinder 插件

                        CKEDITOR.replace( 'item[contact]', {

                        filebrowserBrowseUrl : 'scripts/ckfinder/ckfinder.html',

                        filebrowserImageBrowseUrl : 'scripts/ckfinder/ckfinder.html?Type=Images',

                        filebrowserFlashBrowseUrl : 'scripts/ckfinder/ckfinder.html?Type=Flash',

                        filebrowserUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

                        filebrowserImageUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

                        filebrowserFlashUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

                        });

                        </script></td>
                  </tr>
                <tr>
                    <td class="label">侧边广告:</td>
                    <td bgcolor="#FFFFFF">
                        <textarea name="item[ad_img]" cols="72" rows="12" id="item[ad_img]"><?=$v['item']['ad_img']?></textarea>
                        <script type="text/javascript">

                            // 启用 CKEitor 的上传功能，使用了 CKFinder 插件

                            CKEDITOR.replace( 'item[ad_img]', {

                                filebrowserBrowseUrl : 'scripts/ckfinder/ckfinder.html',

                                filebrowserImageBrowseUrl : 'scripts/ckfinder/ckfinder.html?Type=Images',

                                filebrowserFlashBrowseUrl : 'scripts/ckfinder/ckfinder.html?Type=Flash',

                                filebrowserUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

                                filebrowserImageUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

                                filebrowserFlashUploadUrl : 'scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

                            });

                        </script></td>
                </tr>
                  <tr>
                    <td class="label">版权信息:</td>
                    <td bgcolor="#FFFFFF">
                        <textarea name="item[copyright]" cols="72" rows="12" id="item[copyright]"><?=$v['item']['copyright']?></textarea></td>
                  </tr>
                    <tr>
                        <td class="label">快递费用:</td>
                        <td bgcolor="#FFFFFF">
                            <input name="item[express_price]" type="text" id="item[express_price]" value="<?=$v['item']['express_price']?>" size="72" />
                        </td>
                    </tr>

                    <tr>
                        <td class="label">翻译费用:</td>
                        <td bgcolor="#FFFFFF">
                            <input name="item[interpreter_price]" type="text" id="item[interpreter_price]" value="<?=$v['item']['interpreter_price']?>" size="72" />
                        </td>
                    </tr>

                    <tr>
                        <td class="label">赠送积分:</td>
                        <td bgcolor="#FFFFFF">
                            <input name="item[points]" type="text" id="item[points]" value="<?=$v['item']['points']?>" size="72" />
                        </td>
                    </tr>
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
