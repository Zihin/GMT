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

</head>

<body>
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','报名信息列表');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                <?=$v['title']?>
              </h1>
        <div class="boxcontent">
                <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbox">
                    <tr>
                        <td width="120" align="right" valign="top" class="label">考试名称:</td>
                        <td bgcolor="#FFFFFF">
                    <input name="item[id]" type="hidden" id="item[id]" value="<?=$v['item']['id']?>" />
                    <input name="item[test_name]" type="text" id="test_name" value="<?=$v['item']['test_name']?>" size="10"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="top" class="label">姓名:</td>
                        <td bgcolor="#FFFFFF"><?=$v['item']['stu_name']?></td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="top" class="label">考试编号:</td>
                        <td bgcolor="#FFFFFF"><?=$v['item']['test_no']?></td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="top" class="label">考试中心:</td>
                        <td bgcolor="#FFFFFF"><input name="item[test_center]" type="text" id="test_center" value="<?=$v['item']['test_center']?>" size="10"/></td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="top" class="label">科目:</td>
                        <td bgcolor="#FFFFFF"><input name="item[subject]" type="text" id="subject" value="<?=$v['item']['subject']?>" size="10"/></td>
                    </tr>

                    <tr>
                        <td width="120" align="right" valign="top" class="label">级别:</td>
                        <td bgcolor="#FFFFFF"><input name="item[grade]" type="text" id="grade" value="<?=$v['item']['grade']?>" size="10"/></td>
                    </tr>

                    <tr>
                        <td width="120" align="right" valign="top" class="label">价格:</td>
                        <td bgcolor="#FFFFFF"><?=$v['item']['price']?></td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="top" class="label">曲目:</td>
                        <td bgcolor="#FFFFFF">
                            <?
                            if(is_array($v['item']['program'])){
                                foreach($v['item']['program'] as $key => $val){
                                    //if($val){
                            ?>
                            <input name="item[program][<?=$key?>]" type="text" id="program" value="<?=$val?>" size="10"/>
                            
                            <?
                                   // }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="top" class="label">考试时间范围:</td>
                        <td bgcolor="#FFFFFF"><?=$v['item']['exam_time']?></td>
                    </tr>
                  <tr>
                    <td width="120" class="label">考试具体时间:</td>
                    <td bgcolor="#FFFFFF">
                        <input name="item[test_time]" type="text" id="test_time" value="<?=$v['item']['test_time']?>" size="10"/>
                        <script type="text/javascript">
                            Calendar.setup({
                                inputField     :    "test_time",
                                ifFormat       :    "%Y-%m-%d",
                                button         :    "test_time",
                                singleClick    :    true,
                            });
                        </script>
                  </tr>
                  <tr>
                    <td class="label">分数:</td>
                    <td bgcolor="#FFFFFF"><input name="item[score]" type="text" id="item[score]" value="<?=$v['item']['score']?>" /> </td>
                  </tr>
                </table>
            <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbox">
                <tr>
                    <td colspan="2" align="left" valign="top"><h1>考生信息</h1></td>
                </tr>
                <tr>
                    <td width="120" align="right" valign="top" class="label">姓氏:</td>
                    <td bgcolor="#FFFFFF">
                        <input name="candidate_info[id]" type="text" id="sure_name" value="<?=$v['candidate_info']['id']?>" size="10"/>
                        <input name="candidate_info[sure_name]" type="text" id="sure_name" value="<?=$v['candidate_info']['sure_name']?>" size="10"/></td>
                </tr>
                <tr>
                    <td width="120" align="right" valign="top" class="label">名字:</td>
                    <td bgcolor="#FFFFFF"><input name="candidate_info[given_name]" type="text" id="given_name" value="<?=$v['candidate_info']['given_name']?>" size="10"/></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">中文姓名:</td>
                    <td bgcolor="#FFFFFF"><input name="candidate_info[ch_name]" type="text" id="ch_name" value="<?=$v['candidate_info']['ch_name']?>" size="10"/></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">出生日期:</td>
                    <td bgcolor="#FFFFFF">
                        <input name="candidate_info[birthday]" id="birthday" value="<?=$v['candidate_info']['birthday']?>"  type="text" class="text "/>
               <script type="text/javascript">
Calendar.setup({
	inputField     :    "birthday",
	ifFormat       :    "%Y-%m-%d",
	button         :    "birthday",
	singleClick    :    true
    });
          </script>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">性别:</td>
                    <td bgcolor="#FFFFFF"><?=$v['gender']?></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">身份证/护照号码:</td>
                    <td bgcolor="#FFFFFF"><input name="candidate_info[passport_no]" type="text" id="ch_name" value="<?=$v['candidate_info']['passport_no']?>" size="10"/></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">国籍:</td>
                    <td bgcolor="#FFFFFF"><input name="candidate_info[nationality]" type="text" id="ch_name" value="<?=$v['candidate_info']['nationality']?>" size="10"/></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">电话号码:</td>
                    <td bgcolor="#FFFFFF"><input name="candidate_info[tel]" type="text" id="ch_name" value="<?=$v['candidate_info']['tel']?>" size="10"/></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">邮箱:</td>
                    <td bgcolor="#FFFFFF"><input name="candidate_info[email]" type="text" id="ch_name" value="<?=$v['candidate_info']['email']?>" size="10"/></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">联系地址:</td>
                    <td bgcolor="#FFFFFF"><input name="candidate_info[address]" type="text" id="ch_name" value="<?=$v['candidate_info']['address']?>" size="10"/></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">快递证书:</td>
                    <td bgcolor="#FFFFFF"><?=$v['is_express']?></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">是否需要翻译:</td>
                    <td bgcolor="#FFFFFF"><?=$v['is_interpreter']?></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">上传考生报名照:</td>
                    <td bgcolor="#FFFFFF">
                        <input name="candidate_info[photo]" type="text" id="candidate_info[photo]" value="<?=$v['candidate_info']['photo']?>" />
                        <input onclick="openImageWindow('insertImg','img_preview','candidate_info[photo]')" type="button" name="imgBrowse" value="选择图片" />
                        <div id="img_preview" style="width:120px;height:120px;border:1px solid #eef;">
                        <?=$v['candidate_info']['preview']?>
                      </div>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">上传考生护照/身份证/
                        出生证明/户口本:</td>
                    <td bgcolor="#FFFFFF">
                        <input name="candidate_info[passport_img1]" type="text" id="candidate_info[passport_img1]" value="<?=$v['candidate_info']['passport_img1']?>" />
                        <input onclick="openImageWindow('insertImg','img_preview2','candidate_info[passport_img1]')" type="button" name="imgBrowse" value="选择图片" />
                        <div id="img_preview2" style="width:120px;height:120px;border:1px solid #eef;">
                        <?=$v['candidate_info']['preview2']?>
                      </div>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="label">上传考生身份证反面:</td>
                    <td bgcolor="#FFFFFF">
                        
                        <input name="candidate_info[passport_img2]" type="text" id="candidate_info[passport_img2]" value="<?=$v['candidate_info']['passport_img2']?>" />
                        <input onclick="openImageWindow('insertImg','img_preview3','candidate_info[passport_img2]')" type="button" name="imgBrowse" value="选择图片" />
                        <div id="img_preview3" style="width:120px;height:120px;border:1px solid #eef;">
                        <?=$v['candidate_info']['preview3']?>
                      </div>
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
