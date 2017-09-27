<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>报名第三步</title>
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
                <div class="box01-signin">
                    <?php if ($v['info']): ?>
                    <ul class="signnav">
                        <li>1 ｜ 提交报名</li><li>2 ｜ 在线支付</li><li class="last on">3 ｜ 报名成功</li>
                    </ul>
                    <div class="signer fl">
                        <h6>Test Info.  报考信息</h6>
                        <div class="signerlist">
                            <table class="tab_signer">
                            <tr>
                                <td class="t1">Test Center 考试中心：</td>
                                <td class="t2"><?=$v['info']['test_center']?></td>
                                <td class="t1">Name 姓名：</td>
                                <td class="t2"><?=$v['info']['sure_name']?> <?=$v['info']['given_name']?></td>
                            </tr>
                            <tr>
                                <td class="t1">Grade 级别：</td>
                                <td class="t2"><?=$v['info']['grade']?></td>
                                <td class="t1">Date of Birth 出生日期：</td>
                                <td class="t2"><?=$v['info']['birthday']?></td>
                            </tr>
                            <tr>
                                <td class="t1">Subject 科目：</td>
                                <td class="t2"><?=$v['info']['subject']?></td>
                                <td class="t1">ID No. 身份证/护照号码：</td>
                                <td class="t2"><?=$v['info']['passport_no']?></td>
                            </tr>
                            <tr>
                                <td class="t1">Exam Period 考试时间：</td>
                                <td class="t2"><?=$v['info']['exam_time']?></td>
                                <td class="t1">Telephone No. 电话号码：</td>
                                <td class="t2"><?=$v['info']['tel']?></td>
                            </tr>
                            </table>
                        </div>
                        <div class="testtip"><center><b>恭喜你，报名成功！<br>具体考试时间会在报名预约结束后，在“会员信息”栏目展示，请注意查阅！</b></center></div>
                    </div>
                    <?php else: ?>
                    <div class="signer fl">
                        <div class="testtip"><center><b>支付失败！</b></center></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="side-news fr">
                <?php include TPL_DIR . '/front/right_nav.' . LANGUAGE . '.tpl'; ?>
        </div>
    </div>
</div>
<!-- 脚部 -->

<?php plugin('front_footer'); ?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/upload.js"></script>
<script type="text/javascript">
    window.onload = function () {
        new uploadPreview({ UpBtn: "up_img1", DivShow: "imgdiv1", ImgShow: "imgShow1" });
        new uploadPreview({ UpBtn: "up_img2", DivShow: "imgdiv2", ImgShow: "imgShow2" });
        new uploadPreview({ UpBtn: "up_img3", DivShow: "imgdiv3", ImgShow: "imgShow3" });
    }
</script>
</body>
</html>