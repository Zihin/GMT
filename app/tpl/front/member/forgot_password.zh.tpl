<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>注册</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta http-equiv="Expires" CONTENT="0">
  <meta http-equiv="Cache-Control" CONTENT="no-cache">
  <meta http-equiv="Cache-Control" CONTENT="no-store">
  <link rel="stylesheet" href="css/gmt.css" type="text/css" />
</head>
<body>
<!-- 头部 -->
<?php include TPL_DIR . '/front/header.' . LANGUAGE . '.tpl'; ?>
<!-- 主体 -->
<div class="regarea cf">
  <div class="w1140 pr">
    <div class="regtxt pa">GMT，<br/>拓宽你的音乐视野，<br/>是你正确的导向标！</div>
    <div class="regbox pa">
      <div class="topreg"><li class="log on" style="width:100%;">找回密码：请查收邮件并按提示设置您的密码!</li></div>

      <form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
      <div class="midreg">
        <div class="regpart tc">
          <ul>
            <li>
              <span class="left">密保邮箱：</span>
              <div class="right">
                <input class="text" name="item[email]" id="item[email]" type="text" value="<?=$v['item']['email']?>" placeholder="输入注册时的密保邮箱" />
              </div>
            </li>
            <li><span class="left">
                验证码：</span>
              <div class="right">
                <input name="item[dyncode]" type="text" size="4" class="text text_code fl"  placeholder="右侧验证码" />
                <img src="<?=$v['dyncode_img']?>" id="codeimg"  alt="" width="66" height="29" align="absbottom" class="imgcode fl" onclick="this.src='index.php?default,dyncodeImg,'+Math.random()" />
                <i class="change fl" id="changeimg" onclick="changeimg();return false;">换一张</i>
              </div>
            </li>
          </ul>
          <input type="submit" class="regnow" name="submit"  value="找回密码" />
          <div class="regtip" style="text-align:center;"><?=$v['emsg']['email']?><?=$v['emsg']['dyncode']?></div>
        </div>
      </div>
        </form>
    </div>
  </div>
</div>
<!-- 脚部 -->

<?php plugin('front_footer'); ?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/placeholder2.js"></script>
<script type="text/javascript">
  function changeimg(){
    $('#codeimg').attr('src','index.php?default,dyncodeImg,'+Math.random());
  }

</script>
</body>
</html>