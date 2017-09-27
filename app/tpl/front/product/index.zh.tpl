<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Technology</title>
        <meta charset="utf-8">
        <meta name="description" content="Your description">
        <meta name="keywords" content="Your keywords">
        <meta name="author" content="Your name">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/zerogrid.css">
        <link rel="stylesheet" href="css/responsive.css">
        <script src="js/css3-mediaqueries.js"></script>
        <script src="js/jquery-1.7.1.min.js"></script>
        <script src="js/superfish.js"></script>
        <script src="js/jquery.easing.1.3.js"></script>
        <script src="js/tms-0.4.1.js"></script>
        <script src="js/slider.js"></script>
        <!--[if lt IE 8]>
           <div style=' clear: both; text-align:center; position: relative;'>
             <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
               <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
            </a>
          </div>
        <![endif]-->
        <!--[if lt IE 9]>
                <script src="js/html5.js"></script>
	<link rel="stylesheet" href="css/ie.css"> 
        <![endif]-->
    </head>
    <body>
        <div class="main-bg">
            <!-- Header -->
            <header>
                <!--导航模板导入-->
                <?php plugin('front_nav'); ?>

            </header>
            <!-- Content -->
            <section id="content"><div class="ic">More Website Templates @ TemplateMonster.com | Zerotheme.com</div>
                <div class="zerogrid">
                    <div class="wrapper">
                        <div class="row content-bg">
                            <div class="wrapper">
                                <article class="col-2-3">
                                    <div class="wrap-col">
                                        <h2>最新活动:</h2>
                                        <?php $new = plugin('article_list', 'project', 4, 2); ?>
                                        <?php if (is_array($new['list'])): foreach ($new['list'] as $n): ?>
                                                <div class="wrapper p2 hr-border-1">
                                                    <img src="<?= $n['pic'] ?>" class="img-indent" alt="<?= $n['title'] ?>" style="width:230px;height:120px;">
                                                    <dl class="extra-wrap def-list-1">
                                                        <dt>
                                                        <a href="<?= $n['link'] ?>"><?= $n['title'] ?></a> 
                                                        </dt>
                                                        <dd class="pad-left">
                                                            <?= $n['intro_content'] ?>
                                                        </dd>
                                                    </dl>
                                                </div>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>

                                        <div class="alignright">
                                            <a href="<?= $new['more_link'] ?>" class="button">查看最多</a>
                                        </div>
                                    </div>
                                </article>
                                <article class="col-1-3">

                                    <!-- 左侧相关信息-->
                                    <?php include TPL_DIR . '/front/project/left.' . LANGUAGE . '.tpl'; ?>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Footer -->
            <footer>

                <!--底部模板导入-->
                <?php plugin('front_footer'); ?>
            </footer>
        </div>
    </body>
</html>