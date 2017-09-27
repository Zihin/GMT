<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>关于GMT音乐等级考试</title>
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
                <h2>About GMT</h2>
                <div class="pubtime"><?=$v['cf']['put_time']?>  ｜  About GMT</div>
                <div class="newscon">
                    <?=$v['cf']['company_detail']?>
                </div>
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
</script>
</body>
</html>