<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="加盟连锁七张嘴兒七品焖锅">
<meta name="description" content="加盟连锁七张嘴兒七品焖锅 ">
<meta name="author" content="加盟连七张嘴兒七品焖锅 ">
<title>七张嘴兒 七品焖锅 百年焖锅 享所未想 欢迎加盟</title>
<link type="text/css" rel="stylesheet" href="css/main.css"/>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
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
    <div class="parth">您现在的位置：<a href="index.htm">网站首页</a> >> 联系我们</div>
    <div class="article_title"> 七张嘴七品焖锅的联系方式</div>
    <div class="article">
    <div style="font-size:14px; line-height:20px">
  <?= $v['contact'] ?>
       
    </div>
	<div  align="center">
		<div style="width:100%;height:500px;border:#ccc solid 1px;" id="dituContent"></div>    
      </div>
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
<script type="text/javascript">
    var opts = {
      width : 100,     // 信息窗口宽度
      height: 50,     // 信息窗口高度
      title : "七品焖锅"  // 信息窗口标题
    }
    //创建和初始化地图函数：
    function initMap() {
        createMap(); //创建地图
        setMapEvent(); //设置地图事件
        addMapControl(); //向地图添加控件
    }

    //创建地图函数：
    function createMap() {
        var map = new BMap.Map("dituContent"); //在百度地图容器中创建一个地图
        var point = new BMap.Point(103.85731,30.055028); //定义一个中心点坐标
        map.centerAndZoom(point, 17); //设定地图的中心点和坐标并将地图显示在地图容器中
        window.map = map; //将map变量存储在全局

        //向地图添加标注
        var bounds = map.getBounds();       

        var point = new BMap.Point(103.85731,30.055028);
        var marker = new BMap.Marker(point);
        var label = new BMap.Label('七品焖锅',{"offset":new BMap.Size(9,-15)});
        marker.setLabel(label);
        map.addOverlay(marker);
        marker.addEventListener("click", function(){this.openInfoWindow(new BMap.InfoWindow("Tel:400-8877-131</br>眉山市红星路东延段东延段万景国际1栋1单元301", opts));});
    }
    // 编写自定义函数,创建标注
    function addMarker(point, index) {
        var myIcon = new BMap.Icon("http://api.map.baidu.com/img/markers.png", new BMap.Size(23, 25), {
            offset: new BMap.Size(10, 25),                  // 指定定位位置
            imageOffset: new BMap.Size(0, 0 - index * 25)   // 设置图片偏移
        });
        var marker = new BMap.Marker(point, { icon: myIcon });
        map.addOverlay(marker);
    }

    //地图事件设置函数：
    function setMapEvent() {
        map.enableDragging(); //启用地图拖拽事件，默认启用(可不写)
        map.enableScrollWheelZoom(); //启用地图滚轮放大缩小
        map.enableDoubleClickZoom(); //启用鼠标双击放大，默认启用(可不写)
        map.enableKeyboard(); //启用键盘上下左右键移动地图
    }

    //地图控件添加函数：
    function addMapControl() {
        //向地图中添加缩放控件
        var ctrl_nav = new BMap.NavigationControl({ anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_LARGE });
        map.addControl(ctrl_nav);
        //向地图中添加缩略图控件
        var ctrl_ove = new BMap.OverviewMapControl({ anchor: BMAP_ANCHOR_BOTTOM_RIGHT, isOpen: 1 });
        map.addControl(ctrl_ove);
        //向地图中添加比例尺控件
        var ctrl_sca = new BMap.ScaleControl({ anchor: BMAP_ANCHOR_BOTTOM_LEFT });
        map.addControl(ctrl_sca);
    }
    initMap(); //创建和初始化地图
</script>

</body>
</html>
