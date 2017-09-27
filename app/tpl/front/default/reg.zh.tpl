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
      <div class="topreg"><li class="log" id="login">登录</li><li class="last on">注册</li></div>
      <div class="midreg">
        <div class="regpart tc">
          <form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
          <ul>
            <li>
              <span class="left">用户名：</span>
              <div class="right">
                <input class="text" type="text" name="item[username]" id="item[username]" value="<?=$v['item']['username']?>"  placeholder="邮箱/手机" />
                <?=$v['emsg']['username']?>
              </div>
            </li>
            <li>
              <span class="left">密码：</span>
              <div class="right">
                <input class="text" type="password" placeholder="6位以上数字或英文字母" name="item[passwd]" id="item[passwd]" />
                <?=$v['emsg']['passwd']?>
              </div>
            </li>
            <li>
              <span class="left">重复密码：</span>
              <div class="right">
                <input class="text" type="password" placeholder="6位以上数字或英文字母" name="item[passwd1]" id="item[passwd1]" />
                <?=$v['emsg']['passwd1']?>
              </div>
            </li>
            <li>
              <span class="left">密保邮箱：</span>
              <div class="right">
                <input class="text" name="item[email]" id="item[email]" type="text" value="<?=$v['item']['email']?>" placeholder="忘记密码时发送的邮箱" />
                <?=$v['emsg']['email']?>
              </div>
            </li>
            <li>
              <span class="left">我    是：</span>
              <div class="right">
                <label class="who fl"><input checked type="radio" name="item[gid]" value="1" <?=$v['item']['gid']==1?'checked="checked"':''?>/>个人注册</label>
                <label class="who fl"><input type="radio" name="item[gid]" <?=$v['item']['gid']==2?'checked="checked"':''?> value="2"/>教师注册</label>
              </div>
            </li>
            <li>
              <span class="left">验证码：</span>
              <div class="right">
                <input name="item[dyncode]" type="text" size="4" class="text text_code fl"  placeholder="右侧验证码" />
                <img src="<?=$v['dyncode_img']?>" id="codeimg"  alt="" width="66" height="29" align="absbottom" class="imgcode fl" onClick="this.src='index.php?default,dyncodeImg,'+Math.random()" />
                <i class="change fl" id="changeimg" onClick="changeimg();return false;">换一张</i>
                <div class="fl"><?=$v['emsg']['dyncode']?></div>
              </div>
            </li>
          </ul>
          <input type="submit" class="regnow" name="submit" value="立即注册" />
          <div class="regtip"><center>  &nbsp;&nbsp;个人会员仅可为自己报名，教师会员可为其多名学生报名。</center></div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- 脚部 -->
<?php plugin('front_footer'); ?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/placeholder2.js"></script>
<script type="text/javascript">
  $('#login').click(function(){
    location.href='index.php?default,login';
  });
  function changeimg(){
    $('#codeimg').attr('src','index.php?default,dyncodeImg,'+Math.random());
  }

</script>
</body>
</html>