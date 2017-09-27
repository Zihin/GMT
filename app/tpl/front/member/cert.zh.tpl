<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>GMT-会员查询</title>
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
        <h2>证书查询</h2>
        <div class="ban-query">
          <img src="images/ban_cert.jpg" />
        </div>
        <?
          if($v['result'] == 1){
          ?>

        <div class="box01-result">
          <?php
          if($v['test_info']){
          ?>
          <p>你的证书查询结果存在，具体登记信息如下：</p>
          <ul class="resulitlist">
            <li>会员姓名：<b><?=$v['test_info']['stu_name']?></b></li>
            <li>证书编号：<b><?=$v['test_info']['test_no']?></b></li>
            <li>考证名称：<b><?=$v['test_info']['test_name']?></b></li>
            <li>考证级别：<b><?=$v['test_info']['grade']?></b></li>
            <li>考证成绩：<b><?=$v['test_info']['score'] ? $v['test_info']['score'] : '暂无成绩'?></b></li>
            <li>考证时间：<b><?=$v['test_info']['test_time']?></b></li>
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
          <p>输入证书拥有者姓名和证书编号，可查询证书级别，成绩及考证时间。</p>
          <form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post" class="queryform">
            <ul>
              <li><span>姓氏</span><input type="text" class="text" id="stu_name" name="stu_name" placeholder="样例：chen" /></li>
              <li><span>名字</span><input type="text" class="text" id="given_name" name="given_name" placeholder="样例：xiaoming" /></li>
              <li><span>证书编号</span><input type="text" class="text" id="test_no" name="test_no" placeholder="样例：GMT200000999915"  /></li>
            </ul>
            <input type="submit" class="redbtn" value="立即查询" name="submit" id="gonext">
          </form>
        </div>
        <?
          }
          ?>

      </div>
      <div class="side-news fr">
        <?php include TPL_DIR . '/front/right_nav.' . LANGUAGE . '.tpl'; ?>
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
  $('#gonext').click(function () {
    var username = $('#stu_name').val();
	var givenname = $('#given_name').val();
    var member_code = $('#test_no').val();


    if (username == '') {
      alert('请输入会员姓氏');
      return false;
    }
	if (givenname == '') {
      alert('请输入会员名字');
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