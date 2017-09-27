<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="加盟连锁七张嘴兒七品焖锅">
<meta name="description" content="加盟连锁七张嘴兒七品焖锅 ">
<meta name="author" content="加盟连七张嘴兒七品焖锅 ">
<title>七张嘴兒 七品焖锅 百年焖锅 享所未想 欢迎加盟</title>
<link type="text/css" rel="stylesheet" href="css/main.css" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript">
    $(function() {
        $('#gallery a').lightBox();
    });
    </script>
</head>
<body>
<!--头部 -->
<!--logo -->
<div style="width:100%; height:auto;background-color:#FFCD00;">
<div style="width:96%; height:auto;background-color:#FFC;">

<?php plugin('page_header'); ?>
<?php include TPL_DIR . '/front/nav.' . LANGUAGE . '.tpl';?>
<div class="showder"></div>

<!--主要内容 -->
<div class="page">
  <div class="page_left">
    <div class="parth">您现在的位置：<a href="index.php">首页</a> &gt;&gt; 产品中心</div>
    <div class="article_title"> 产品中心</div>
    <div class="pro" id="gallery">
  <ul>
  <?php if (is_array($v['list'])): foreach ($v['list'] as $i): ?>
    <li>
    	<a href="<?= $i['pic'] ?>" title="<?= $i['title'] ?>">
        	<img src="<?= $i['pic'] ?>" border="0" width="100%" height="100%;"/>
        </a>
    </li>
         <?php endforeach;else: ?>
               <li>暂时还没有产品...</li>
            <?php endif; ?>
	  </ul>
      </div>
    
                                            <div >
                                                <!--翻页-->
                                                <?= $v['page_index'] ?>
                                            </div>
  </div>
  <!--右侧-->
<?php include TPL_DIR . '/front/right.' . LANGUAGE . '.tpl'; ?>
  <div class="clear"></div>
</div>
<!--底部开始-->
<div class="ffmm"></div>
	<!--footer -->
<div class="footer">

<?php plugin('front_footer'); ?>
</div>
</div>
</div>


	<!--banner切换-->
<script src="js/fn.js"></script>
<script type='text/javascript'>

  (function(){

 var nav= document.getElementById('navi');

  var fnav= function(){

   var top= document.documentElement.scrollTop||document.body.scrollTop;
   if(top < 535){

    nav.style.display = 'block';

    nav.style.marginTop="0px";

   }else{

 nav.style.marginTop= top - "535" +"px";

 

  }


  }

window.onload =window.onscroll = fnav;

  })();

</script>

<script>
        $(document).ready(function() {
            var k_total_pics = $('.k_banner .pics li').length,
                k_html_str = '<div class="tabs">';
            for (var i = 0; i < k_total_pics; i++) {
                if (i == 0) {
                    k_html_str += '<b class="on"></b>';
                } else {
                    k_html_str += '<b></b>';
                }
            }
            k_html_str += '</div>';
            $('.k_banner').append(k_html_str);
            slidePics($('.k_banner .tabs b'), $('.k_banner .pics li'));
            autoSlide($('.k_banner .tabs b'), $('.k_banner .pics li'));
            function setPosition() {
                $('.k_banner .tabs').css({
                    left: ($('body').width() - $('.k_banner .tabs').width()) / 2
                });
            }
            setPosition();
            $(window).resize(function() {
                setPosition();
            });
        });
</script>

</body>
</html>
