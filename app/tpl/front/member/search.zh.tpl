<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>会员查询</title>
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
<div class="newsarea cf">
  <div class="w1140">
    <div class="newsbox l">
      <div class="content-news fl">
        <h2>教师查询</h2>
        <div class="ban-query">
          <img src="images/ban_query.jpg" />
        </div>
          <?
          if($v['result'] == 1){
          ?>

        <div class="box01-result">
          <?php
          if($v['meb_info']){
          ?>
          <p>你的教师查询结果存在，具体登记信息如下：</p>
          <ul class="resulitlist">
            <li>会员编号：<b><?=$v['meb_info']['member_code']?></b></li>
            <li>会员类型：<b><?=$v['meb_info']['type']?></b></li>
            <li>注册时间：<b><?=$v['meb_info']['reg_date']?></b></li>
            <li>会员级别：<span class="rzmem"><b><?=$v['meb_info']['groupname']?></b></span></li>
          </ul>
          <?php
          }else{
          ?>

          <p>你的查询结果不存在！</p>
          <?php
          }
          ?>
        </div>
          <?
          }else{
          ?>

        <div class="box01-query">
          <p>输入教师姓名和编号，可查询该教师状态。</p>
          <form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post" class="queryform">
            <ul>
              <li><span>教师姓名</span><input type="text" class="text" id="username_t" name="username_t" /></li>
              <li><span>教师编号</span><input type="text" class="text" id="member_code_t" name="member_code_t"  /></li>
            </ul>
            <input type="submit" class="redbtn" value="立即查询" name="submit" id="gonext">
          </form>
        </div>
          <?
          }
          ?>

      </div>
      <div class="side-news fr">
        <?php include TPL_DIR . '/front/member/right.' . LANGUAGE . '.tpl'; ?>
      </div>
    </div>
  </div>
</div>
<!-- 脚部 -->
<?php plugin('front_footer'); ?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
  $('.topreg li').click(function(){
    $(this).addClass('on');
    $(this).siblings().removeClass('on');
    var i=$(this).index();
    $('.regpart').hide();
    if(i==1){
      $('.regpart').eq(0).show();
    }
    if(i==0){
      $('.regpart').eq(1).show();
    }
  })
  //提交验证
  $('#gonext').click(function () {
    var username = $('#username_t').val();
    var member_code = $('#member_code_t').val();


    if (username == '') {
      alert('请输入会员姓名');
      return false;
    }
    if (member_code == '') {
      alert('请输入会员编号');
      return false;
    }

  })
</script>
</body>
</html>