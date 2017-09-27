<?php $cf = plugin('getconfig');?>
<div class="pfd l">
    <div class="w1140">
        <div class="box01-ft fl">
            <div class="part01-ft fl">
                <div class="fttitle">Contact us</div>
                <div class="contactinfo">
                    <?=$cf['contact']?>
                </div>
            </div>
            <div class="part02-ft fl">
                <div class="fttitle">Links</div>
                <dl class="taglist">
                    <?php $link = plugin('link_list', 9); ?>
                    <?php if (is_array($link['list'])): foreach ($link['list'] as $n): ?>
                    <a href="<?=$n['link']?>" target="_blank"?><dt><!--<?=$n['short_title']?>--><?=$n['title']?></dt></a>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </dl>
            </div>
            <div class="part02-ft fl">
                <div class="fttitle">Add WeChat</div>
                <div class="ewm"><?=$cf['company_intro']?></div>
            </div>
            <div class="part02-ft fl">
                <div class="fttitle">Site Navigation</div>
                <ul class="ftnav">
                    <li><a href="index.php?article,showlist,cate,5">News</a></li>
                    <li><a href="?default,about">About GMT</a></li>
                    <li><a href="index.php?article,showlist,cate,6">Programs</a></li>
                    <li><a href="?single,view,id,21">Scholarships</a></li>
                    <!--
                        <li><a href="index.php?member,memberinfo">教师中心</a></li>
                    -->
                </ul>
            </div>
        </div>
        <div class="box02-ft cf">
            <span class="fr"><?=$cf['copyright']?></span>
            <img src="images/logo_s.png" class="logo_s fl">
        </div>
    </div>
</div>