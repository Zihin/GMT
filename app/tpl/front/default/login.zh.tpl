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
      <div class="topreg"><li class="log on">登录</li><li class="last " id="reg">注册</li></div>
      <div class="midreg">
        <form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
        <div class="regpart tc">
          <ul>
            <li>
              <span class="left">用户名：</span>
              <div class="right">
                <input class="text" type="text" placeholder="邮箱/手机" name="username"  id="username" value="<?=$v['username']?>" />
                <?=$v['emsg']['username']?>
              </div>
            </li>
            <li>
              <span class="left">密码：</span>
              <div class="right">
                <input class="text" type="password" placeholder="6位以上数字或英文字母" name="password" id="password" />
                <?=$v['emsg']['password']?>
              </div>
            </li>
            <li>
              <span class="left">验证码：</span>
              <div class="right">
                <input name="dyncode" type="text" size="4" class="text text_code fl"  placeholder="右侧验证码" />
                <img src="<?=$v['dyncode_img']?>" id="codeimg" alt="" width="66" height="29" align="absbottom" class="imgcode fl"  onclick="this.src='index.php?default,dyncodeImg,'+Math.random()" />
                <i class="change fl" onclick="changeimg();return false;">换一张</i>
                <div class="fl"><?=$v['emsg']['dyncode']?></div>
              </div></li>

            <li class="fl"><?=$v['emsg']['msg']?></li>
          </ul>
          <input type="hidden" name="isdycode" value="1">
          <input type="submit" class="regnow" value="立即登录" name="submit"/>
          <div class="regtip"><a href="index.php?member,forgot_password">忘记密码？</a></div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- 脚部 -->
<?php plugin('front_footer'); ?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/placeholder2.js"></script>
<script type="text/javascript">
  $('#reg').click(function(){
    location.href='index.php?default,reg';
  });
  function changeimg(){
    $('#codeimg').attr('src','index.php?default,dyncodeImg,'+Math.random());
  }

</script>
</body>
</html>