<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>系统信息</title>
    <?=$v['toTop']?>
    <style type="text/css">
        <!--
        body, td, th {
            margin: 5px;
        }

        a {
            color: #ff6633;
            text-decoration: none;
        }

        a:hover {
            color: #ff6633;
            text-decoration: underline;
        }
    </style>
    <link href="scripts/global.css" rel="stylesheet" type="text/css"/>
</head>

<body style="text-align:center; padding:5px;">
<div class="winbox" style="width:480px;margin:0 auto; text-align:left;"><b class="b1"></b><b class="b2"></b><b
            class="b3"></b><b class="b4"></b>
    <h1>系统信息</h1>
    <div class="boxcontent" style="font:14px/24px '宋体'; padding:15px 15px 5px 30px;"><img src="imgs/icon/i.gif"/>
        <?=$v['msg']?>
        <div align="right"
             style="padding-top:20px;"><?php if($v['links']) echo "{$v['links']}"; else echo "<a href='{$_SERVER['HTTP_REFERER']}'>
            返回上一页</a>"?>
        </div>
    </div>
    <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></div>
</body>
</html>