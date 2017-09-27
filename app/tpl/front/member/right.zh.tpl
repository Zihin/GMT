<?php $adcf2 = plugin('getconfig');?>
<h2 class="h2title">教师中心</h2>
<ul class="examlist">
    <li class="home <?php echo ($v['self_id'] == 'memberinfo') ?  'on' : ''; ?>"><a href="index.php?member,memberinfo">会员信息</a></li>
    <li class="<?php echo ($v['self_id'] == 'search') ?  'on' : ''; ?>"><a href="index.php?member,search">教师查询</a></li>
    <?
    if($_SESSION['user']['gid'] > 1){
    ?>
    <li <?php echo ($v['self_id'] == 'article_7') ?  'class="on"' : ''; ?>><a href="index.php?article,showlist,cate,7">教师天地</a></li>
    <li class="<?php echo ($v['self_id'] == 'mebupdate') ?  'on' : ''; ?>"><a href="index.php?member,mebupdate">教师升级</a></li>
    <?
    }
    ?>
</ul>
<?=$adcf2['ad_img']?>