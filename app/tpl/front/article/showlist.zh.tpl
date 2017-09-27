<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>GMT-<?=$v['cate_name']?></title>
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
        <h2><?=$v['cate_name']?></h2>
        <ul class="newslist">
          <?php if (is_array($v['list'])): foreach ($v['list'] as $i): ?>
          <li><a href="<?=$i['link']?>">
              <img class="itemimg pa" src="<?= $i['pic'] ?>" />
              <div class="grp"><h6><?=$i['title']?></h6>
                <p><?=$i['intro_content']?></p>
                <div class="date"><?=$i['put_time']?></div></div></a></li>
          <?php endforeach;else: ?>
          <li>暂时还没有信息...</li>
          <?php endif; ?>
        </ul>
        <div class="pagenews cf tr">

          <!--翻页-->
          <?= $v['page_index'] ?>
        </div>
      </div>
      <div class="side-news fr">
        <?
        if($v['nav_id'] == 'member'){
        ?>
        <?php include TPL_DIR . '/front/member/right.' . LANGUAGE . '.tpl'; ?>
        <?
        }elseif($v['nav_id'] == 'news'){
        ?>
        <?php include TPL_DIR . '/front/article/news_nav.' . LANGUAGE . '.tpl'; ?>
        <?
        }else{
        ?>
        <?php include TPL_DIR . '/front/right_nav.' . LANGUAGE . '.tpl'; ?>
        <?
        }
        ?>
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