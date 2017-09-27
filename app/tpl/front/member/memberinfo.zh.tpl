<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>GMT-会员信息</title>
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
                <h2 class="updatetitle">会员信息</h2>
                <div class="col01-member l">

                    <form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
                    <div class="box01-member pr">
                        <table class="tab01-member">
                            <tr>
                                <td class="t1">会员编号：</td>
                                <td class="t2"><?=$v['memberinfo']['member_code']?></td>
                                <td class="t1">会员类型：</td>
                                <td class="t2"><?=$v['memberinfo']['gid']?></td>
                            </tr>
                            <tr>
                                <td class="t1">注册时间：</td>
                                <td class="t2"><?=$v['memberinfo']['reg_date']?></td>
                                <td class="t1">会员积分： </td>
                                <td class="t2"><?=$v['memberinfo']['points']?></td>
                            </tr>
                            <tr><td class="t1">姓名：</td>
                                <td class="t2">
                                    <input type="text" placeholder="教师必须填英文名或拼音,例:lihua" class="text" name="item[name]" value="<?=$v['item']['mobile']?$v['item']['name']:$v['memberinfo']['name']?>" />
                                    <?=$v['emsg']['name']?>
                                </td>
                                <td class="t1">手机：</td>
                                <td class="t2">
                                    <input type="text" class="text" name="item[mobile]" value="<?=$v['item']['mobile']?$v['item']['mobile']:$v['memberinfo']['mobile']?>"/>
                                    <?=$v['emsg']['mobile']?>
                                </td>
                            </tr>
                            <tr><td class="t1">性别：</td>
                                <td class="t2">
                                    <?=$v['item']['sex']?>
                                    <?=$v['emsg']['sex']?>
                                </td>
                                <td class="t1">登录密码：</td><td class="t2"><input type="password" placeholder="不填写则维持原密码" class="text" name="item[passwd]"  /></td></tr>
                        </table>
                        <input type="submit" class="redbtn fr" name="submit" value="修改会员信息">
                    </div>
                        </form>
                    <?php if (is_array($v['list'])): foreach ($v['list'] as $i): ?>
                    <div class="box02-member cf">
                        <div class="recordtitle pr"><a href="index.php?member,printtest,id,<?=$i['id']?>" target="_blank" class="print pa">打印考试表单</a>报考记录 / <span class="red"><?=$i['test_no']?></span></div>
                        <div class="part01-member">
                            <div class="membertitle">考生信息</div>
                            <table class="tab01-record">
                                <tr><td width="50%"><?=$i['stu_name']?></td><td>确认考试时间：<?=$i['test_time']?></td></tr>
                            </table>
                            <div class="membertitle">考试信息</div>
                            <table class="tab01-record">
                                <tr><td width="25%"><?=$i['test_center']?></td><td width="25%">级别 <?=$i['grade']?></td><td width="25%"><?=$i['subject']?></td><td><?=$i['exam_time']?> </td></tr>
                            </table>
                        </div>
                    </div>
                    <?php endforeach;else: ?>
                    <li></li>
                    <?php endif; ?>
                    <div class="pagenews cf tr">
                        <?= $v['page_index'] ?>
                    </div>
                </div>
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
<script type="text/javascript" src="js/upload.js"></script>
<script type="text/javascript">
    window.onload = function () {
        new uploadPreview({ UpBtn: "up_img1", DivShow: "imgdiv1", ImgShow: "imgShow1" });
        new uploadPreview({ UpBtn: "up_img2", DivShow: "imgdiv2", ImgShow: "imgShow2" });
        new uploadPreview({ UpBtn: "up_img3", DivShow: "imgdiv3", ImgShow: "imgShow3" });
        new uploadPreview({ UpBtn: "up_img4", DivShow: "imgdiv4", ImgShow: "imgShow4" });
    }
</script>
</body>
</html>