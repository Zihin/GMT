<div class="phd l">
    <div class="w1140">
        <div class="box01-hd fr">
            <?
        if($_SESSION['data']['username']){
      ?>
            <div class="part01-hd fr">
                <a class="regbtn fl" href="index.php?default,logoff">退出</a>
            </div>

            <ul class="part02-hd fr">
                <li>欢迎你,<?=$_SESSION['data']['username']?></li>
            </ul>
            <?
      }else{
      ?>
            <form id="main_form" name="main_form" action="index.php?default,login" method="post">
                <div class="part01-hd fr">
                    <input class="regbtn fl" type="submit" value="Log in" name="submit"
                           onclick="if(0 == document.getElementById('username').value.length || 0 == document.getElementById('password').value.length){alert('请将用户名和密码输入完整......');return false;}"/>
                    <input type="hidden" name="isdycode" value="0">
                    <a class="regbtn fl" href="index.php?default,reg">Sign up</a>
                </div>
                <ul class="part02-hd fr">
                    <li><span>Username</span><input type="text" class="text" name="username" id="username"
                                                    placeholder=""/></li>
                    <li><span>Password</span><input type="password" class="text" placeholder="" name="password"
                                                    id="password"/></li>
                </ul>
            </form>
            <?
        }
        ?>
        </div>
        <div class="box02-hd cf"><!--<?=$v['self_id']?>-->
            <a href="index.php" class="logo fl">gmt</a>
            <ul class="nav fr"><!-- <?php echo $v['self_id']; ?>-->
                <li class="home <?php echo ($v['self_id'] == 'index') ?  'select' : ''; ?>"><a href="index.php">Home</a>
                </li>
                <li
                <?php echo ($v['self_id'] == 'article_5') ?  'class="select"' : ''; ?>><a
                        href="index.php?article,showlist,cate,5">News</a></li>
                <li
                <?php echo ($v['nav_id'] == 'gmt') ?  'class="select"' : ''; ?>><a href="?default,about">About
                    GMT</a></li>
                <li
                <?php echo ($v['self_id'] == 'article_6') ?  'class="select"' : ''; ?>><a
                        href="index.php?article,showlist,cate,6">Programs</a></li>
                <li
                <?php echo ($v['self_id'] == 'single_21') ?  'class="select"' : ''; ?>><a
                        href="?single,view,id,21">Scholarship</a></li>
                <!--
                                <li
                                <?php echo ($v['nav_id'] == 'member') ?  'class="select"' : ''; ?>><a
                                        href="index.php?member,memberinfo">教师中心</a></li>
                                        -->
            </ul>
        </div>
    </div>
</div>