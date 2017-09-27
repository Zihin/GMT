<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>GMT考试中文官网hfjldskj</title>
    <meta name="keywords" content="GMT" />
    <meta name="description" content="GMT，greferfergfdc一个国际先进的测试系统，一张世界公认的等级证书。" />
    <meta http-equiv="Expires" CONTENT="0">
    <meta http-equiv="Cache-Control" CONTENT="no-cache">
    <meta http-equiv="Cache-Control" CONTENT="no-store">
    <link rel="stylesheet" href="css/gmt.css" type="text/css" />
</head>
<body>
<!-- 头部 -->
<?php include TPL_DIR . '/front/header.' . LANGUAGE . '.tpl'; ?>
<!-- 主体 -->
<div class="w1140 cf">
    <div class="area01-info l">
        <!-- 幻灯片 -->
        <div class="index_focus pr fl">
            <div class="bd">
                <ul>

                    <?php $new5 = plugin('article_list', 'article', 4, 5,1); ?>
                    <?php if (is_array($new5['list'])): foreach ($new5['list'] as $n): ?>
                    <li><img src="<?= $n['pic'] ?>"  />
                        <div class="txt">
                            <a href="<?= $n['link'] ?>" >
                            <h6><?= $n['title'] ?></h6>
                            <p><?= $n['intro_content'] ?></p>
                           </a>
                        </div>
                        <div class="txtbg">
                         </div>
                    </li>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </ul>
                <div class="slide_nav">
                    <div class="navctrl">

                        <?php if (is_array($new5['list'])): foreach ($new5['list'] as $n): ?>
                        <a href="javascript:void(0);" ></a>
                        <?php
                    endforeach;
                    endif;
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="infobox fr">
            <div class="title"><b>Exam Information</b></div>
            <ul class="recomdtxt">
                <?php $new = plugin('article_list', 'article', 4, 4,1); ?>
                <?php if (is_array($new['list'])): foreach ($new['list'] as $n): ?>
                <li><a href="<?= $n['link'] ?>"><h6><?= $n['short_title'] ?></h6>
                        <p><?= $n['intro_content'] ?></p></a></li>
                <?php
                endforeach;
                endif;
                ?>
            </ul>
            <a class="more fr" href="index.php?article,showlist,cate,4"><img src="images/more.png" /></a>
        </div>
    </div>
    <!-- 报名 -->
    <div class="area01-sign l">
        <div class="box01-sign fl">
            <h6>balabalabalabalaba999</h6>
            <p>GMT，fdsvsdvsafgvfsdavsftgsfdvrdsnjklnvfwaslnfewsjafoljmd.</p>
        </div>
        <a href="index.php?member,singup" class="signbtn fl"><img src="images/signbtn.png" /></a>
    </div>
    <!-- 其它推荐 -->
    <ul class="itemlist l">
        <li><a href="index.php?default,about"><img src="images/item01.jpg" /><div class="grp"><h6>About us</h6><p>jnhklswfnkjsebnfkcjseafewsda</p></div></a></li>
        <li class="mr0"><a href="index.php?single,view,id,20"><img src="images/item02.jpg" /><div class="grp"><h6>Repertoires</h6><p>   </p></div></a></li>
        <li><a href="index.php?single,view,id,22"><img src="images/item03.jpg" /><div class="grp"><h6>Syllabus</h6><p>hbtgrbgbgtrbstdfgs</p></div></a></li>
        <li class="mr0"><a href="index.php?member,cert"><img src="images/item04.jpg" /><div class="grp"><h6>Certificate Verify</h6><p>rgsdvffcewdfscafwe efdsa</p></div></a></li>
    </ul>
    <!-- 认证教师 -->
    <div class="area01-declare l">
        <div class="box01-declare fl">
            <h5 class="h5title">Certified Teacher</h5>
            <div class="txt">
                <p>bgfewdjchbnweikjf weohf ocshjkn welefhoo wejak fjdcoh<br>
                hfoejwhcnkl whojfhcnqwklce nwefiohdjnmclwe</p>
            </div>
            <a class="rzbtn" href="index.php?member,mebupdate"><img src="images/rzbtn1.gif" /></a>
            <a class="rzbtn" href="index.php?member,search"><img src="images/rzbtn2_.gif" /></a>
        </div>
        <div class="box02-declare fl">
            <h5 class="h5title"><a href="index.php?article,showlist,cate,6" class="more fr"><img src="images/more.png" /></a>Programs</h5>
            <ul class="techlist l">

                <?php $jy = plugin('article_list', 'article', 3, 6,1); ?>
                <?php if (is_array($jy['list'])): foreach ($jy['list'] as $n): ?>
                <li><a href="<?= $n['link'] ?>"><img width="232" height="175" src="<?= $n['pic'] ?>" />
                        <div class="desc"><h6><?= $n['short_title'] ?></h6>
                            <p><?= $n['intro_content'] ?></p></div>
                    </a></li>
                <?php
                endforeach;
                endif;
                ?>
            </ul>
        </div>
    </div>
</div>
<!-- 脚部 -->
<?php plugin('front_footer'); ?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.SuperSlide.js"></script>
<script type="text/javascript">
    $(document).ready(function(e){
        $(".index_focus").slide({
            titCell: ".slide_nav a ",
            mainCell: ".bd ul",
            delayTime: 1000,
            interTime: 3500,
            prevCell:".prev",
            nextCell:".next",
            effect: "fold",
            autoPlay: true,
            trigger: "click",
            startFun:function(i){

            }
        });
    });
</script>
</body>
</html>