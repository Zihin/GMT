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
      <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','发布考试信息');?>
          <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
      <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
      <td valign="top"><div class="winbox"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
              <h1>
                <?=$v['title']?>
              </h1>
        <div class="boxcontent">
                <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbox">
                  <tr>
                    <td width="120" class="label">科目名称:
                    <input name="item[id]" type="hidden" id="item[id]" value="<?=$v['item']['id']?>" /></td>
                    <td bgcolor="#FFFFFF"><input name="item[test_name]" type="text" id="item[test_name]" value="<?=$v['item']['test_name']?>" />
                      <span class="red">*</span>
                      <?=$v['emsg']['test_name']?></td>
                  </tr>
                  <tr>
                    <td width="120" class="label">科目名称:</td>
                    <td bgcolor="#FFFFFF"><input name="item[subject]" type="text" id="item[subject]" value="<?=$v['item']['subject']?>" />
                      <span class="red">*</span>
                      <?=$v['emsg']['subject']?></td>
                  </tr>
                    <tr>
                        <td width="120" class="label">考试中心:</td>
                        <td bgcolor="#FFFFFF"><?=$v['item']['center']?>
                            <span class="red">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="120" class="label">考试时间:</td>
                        <td bgcolor="#FFFFFF">
                            <input name="item[exam_time]" type="text" id="item[exam_time]" value="<?=$v['item']['exam_time']?>" style="width: 300px;" />
                            <span class="red">*</span>
                            <span class="tips">考试时间段用#号分割如2016/03 - 2016/04#2016/08 - 2016/10</span>
                            <?=$v['emsg']['exam_time']?>
                        </td>
                    </tr>
                    <tr>
                        <td width="120" class="label">级别/价格:</td>
                        <td bgcolor="#FFFFFF">
                            <table id="grade">
                                <?
                                if($v['item']['grade']){
                                    foreach($v['item']['grade'] as $key => $val){
                                ?>
                                <tr>
                                    <td>
                                    <input name="item[grade][]" type="text" id="item[grade][]" value="<?=$val?>" /> /
                                    <input name="item[price][]" type="text" id="item[price][]" value="<?=$v['item']['price'][$key]?>" />
                                    <span class="red">*</span>
                                        <?
                                        if($key > 0){
                                        ?>
                                        <input type="button" name="removeitem" class="removeitem" onclick="remove_tr(this)" value="-">
                                        <?
                                        }else{
                                        ?>
                                        <input type="button" name="additem" id="additem" onclick="addtr()" value="+">
                                        <?
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?
                                    }
                                }else{
                                ?>
                                <tr>
                                    <td>
                                        <input name="item[grade][]" type="text" id="item[grade][]" value="" /> /
                                        <input name="item[price][]" type="text" id="item[price][]" value="" />
                                        <span class="red">*</span><input type="button" name="additem" id="additem" onclick="addtr()" value="+">
                                    </td>
                                </tr>
                                <?
                                }
                                ?>
                            </table>
                            <?=$v['emsg']['grade']?>
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
<script type="text/javascript" src="scripts/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
//在元素内部追加内容
        function addtr() {
            var addcontent = '<tr><td>' +
                    '<input name="item[grade][]" type="text" id="item[grade][]" value="" /> / ' +
                    '<input name="item[price][]" type="text" id="item[price][]" value="" />' +
                    '<input type="button" name="removeitem" class="removeitem" onclick="remove_tr(this)" value="-">' +
                    '</td></tr>';
            $("#grade").append(addcontent);
        }
        function remove_tr(obj){
            $(obj).parent().parent().remove();
        }

</script>
</body>
</html>
