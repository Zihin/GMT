<?php $adcf = plugin('getconfig');?>
<h2 class="h2title">About GMT</h2>
<ul class="examlist">
    <li
    <?php echo ($v['self_id'] == 'about') ?  'class="on"' : ''; ?>><a href="?default,about">About GMT</a></li>
    <li
    <?php echo ($v['self_id'] == 'single_20') ?  'class="on"' : ''; ?>><a href="?single,view,id,20">Repertoires</a></li>
    <li
    <?php echo ($v['self_id'] == 'article_4') ?  'class="on"' : ''; ?>><a
            href="index.php?article,showlist,cate,4">News</a></li>
    <li
    <?php echo ($v['self_id'] == 'singup') ?  'class="on"' : ''; ?>><a href="index.php?member,singup">Online
        Registration</a></li>
    <li
    <?php echo ($v['self_id'] == 'cert') ?  'class="on"' : ''; ?>><a href="index.php?member,cert">Certificate
        Verify</a></li>
</ul>
<?=$adcf['ad_img']?>