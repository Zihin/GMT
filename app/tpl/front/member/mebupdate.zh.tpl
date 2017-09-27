<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>会员升级</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="Expires" CONTENT="0">
    <meta http-equiv="Cache-Control" CONTENT="no-cache">
    <meta http-equiv="Cache-Control" CONTENT="no-store">
    <link rel="stylesheet" href="css/gmt.css" type="text/css"/>
</head>
<body>
<!-- 头部 -->
<?php include TPL_DIR . '/front/header.' . LANGUAGE . '.tpl'; ?>
<!-- 主体 -->
<div class="newsarea cf">
    <div class="w1140">
        <div class="newsbox l">
            <div class="content-news fl">
                <h2 class="updatetitle">会员升级</h2>

                <div class="box01-update l">
                    <ul class="part01-update">
                        <li>初级教师升认证教师，需要有一名学生成功通过任一级别考试；</li>
                        <li>认证会员升级为高级会员，需要有一名学生通过十级考试，且获得成绩为优秀。</li>
                        <li>高级会员如果2年内没有学生参加本考试，降级为认证会员。</li>
                        <li>教师会员上传个人资料，后台人工审核后即可升级；</li>
                    </ul>

                    <form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post"
                          enctype="multipart/form-data">                                    	<img id="tempimg" dynsrc="" src="" style="display:none" />

                        <ul class="part02-update">
                            <li><span class="left">姓名：</span>

                                <div class="grp">
                                    <input name="item[name]" id="name"
                                           value="<?=$v['item']['mobile']?$v['item']['name']:$v['memberinfo']['name']?>"
                                           placeholder="请填写真实姓名" type="text"
                                           class="text text_name"/>
                                </div>
                            </li>
                            <li><span class="left">性别：</span>

                                <div class="grp"><?=$v['item']['gender']?></div>
                            </li>
                            <li><span class="left">手机：</span>

                                <div class="grp"><input type="text" name="item[mobile]" id="mobile"
                                                        value="<?=$v['item']['mobile']?$v['item']['mobile']:$v['memberinfo']['mobile']?>" class="text text_phone"/>
                                </div>
                            </li>
                            <li class="photo"><span class="left">证件照片：</span>

                                <div class="grp">
                                    <div class="imgdiv" id="imgdiv1">
                                        <input type="file" class="fl" id="up_img1" name="photo"/>
                                <?
                                if($v['memberinfo']['photo']){
                                ?>
                                    <img id="imgShow1" src="uploads/<?=$v['memberinfo']['photo']?>" class="previmg cf"/>
                                <?
                                }else{
                                ?>
                                    <img id="imgShow1" src="images/card01.jpg" class="previmg cf"/>
                                <?
                                }
                                ?>
                                </div>
                            </li>
                            <li class="photo"><span class="left">毕业证书扫描件：</span>

                                <div class="grp"><input type="file" class="fl" id="up_img2" name="certificate_img"/>

                                    <div class="imgdiv" id="imgdiv2"></div>
                                    <?
                                if($v['memberinfo']['certificate_img']){
                                ?>
                                    <img id="imgShow2" src="uploads/<?=$v['memberinfo']['certificate_img']?>" class="previmg cf"/>
                                    <?
                                }else{
                                ?>
                                    <img id="imgShow2" src="images/card04.jpg" class="previmg cf"/>
                                    <?
                                }
                                ?>
                                </div>
                            </li>
                            <li class="photo"><span class="left">身份证正面扫描件：</span>

                                <div class="grp"><input type="file" class="fl" id="up_img3"  name="card_img1"/>

                                    <div class="imgdiv" id="imgdiv3"></div>
                                    <?
                                if($v['memberinfo']['card_img1']){
                                ?>
                                    <img id="imgShow3" src="uploads/<?=$v['memberinfo']['card_img1']?>" class="previmg cf"/>
                                    <?
                                }else{
                                ?>
                                    <img id="imgShow3" src="images/card02.jpg" class="previmg cf"/>
                                    <?
                                }
                                ?>
                                </div>
                            </li>
                            <li class="photo"><span class="left">身份证反面扫描件：</span>

                                <div class="grp"><input type="file" class="fl" id="up_img4" name="card_img2"/>

                                    <div class="imgdiv" id="imgdiv4"></div>
                                    <?
                                if($v['memberinfo']['card_img2']){
                                ?>
                                    <img id="imgShow4" src="uploads/<?=$v['memberinfo']['card_img2']?>" class="previmg cf"/>
                                    <?
                                }else{
                                ?>
                                    <img id="imgShow4" src="images/card03.jpg" class="previmg cf"/>
                                    <?
                                }
                                ?>
                                </div>
                            </li>
                        </ul>
                        <div class="btnbox tc">
                            <?
                            if($v['memberinfo']['is_apply']==1){
                            ?>
                            <span class="graytn">升级审核中</span>
                            
                            <?
                            }elseif($v['memberinfo']['is_apply']==3){
                            ?>
                            <input type="submit" value="提交审核" name="submit" class="redbtn tjbtn"/>
                            <div id="regtip" class="regtip" style="width:700px;"><p>你的审核未通过，请检查是否符合升级要求及上传信息文件的正确性后，再提交升级！</p></div>
                            <div id="loadtip" class="regtip" style="width:700px; display:none;"><p><img src="imgs/icon/i.gif" align="absmiddle" /> 数据上传中，请耐心等候！</p></div>
                            <?
                            }elseif($v['memberinfo']['is_apply']==2){
                            ?>
                            <input type="submit" value="提交审核" name="submit" class="redbtn tjbtn"/>
                            <div id="regtip" class="regtip" style="width:700px;"><p>你的升级申请已经审核通过！</p></div>
                            <div id="loadtip" class="regtip" style="width:700px; display:none;""><p><img src="imgs/icon/i.gif" align="absmiddle" /> 数据上传中，请耐心等候！</p></div>
                            <?
                            }else{
                            ?>
                            <input type="submit" value="提交审核" name="submit" class="redbtn tjbtn"/>
                            <div id="loadtip" class="regtip" style="width:700px; display:none;""><p><img src="imgs/icon/i.gif" align="absmiddle" /> 数据上传中，请耐心等候！</p></div>
                            <?
                            }
                            ?>
                        </div>
                    </form>
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
        new uploadPreview({UpBtn: "up_img1", DivShow: "imgdiv1", ImgShow: "imgShow1"});
        new uploadPreview({UpBtn: "up_img2", DivShow: "imgdiv2", ImgShow: "imgShow2"});
        new uploadPreview({UpBtn: "up_img3", DivShow: "imgdiv3", ImgShow: "imgShow3"});
        new uploadPreview({UpBtn: "up_img4", DivShow: "imgdiv4", ImgShow: "imgShow4"});
    }
    //提交验证
	
		//检测文件大小 var star
        var max_size = 2*1024*1024;//2M  
        var errMsg = "上传的附件文件不能超过2M！！！";  
        var tipMsg = "您的浏览器暂不支持计算上传文件的大小，确保上传文件不要超过2M，建议使用IE、FireFox、Chrome浏览器。";  
        var browserCfg = {};  
        var ua = window.navigator.userAgent;  
        if (ua.indexOf("MSIE")>=1){  
            browserCfg.ie = true;  
        }else if(ua.indexOf("Firefox")>=1){  
            browserCfg.firefox = true;  
        }else if(ua.indexOf("Chrome")>=1){  
            browserCfg.chrome = true;  
        }  
		//检测文件大小 var end

    $('.tjbtn').click(function () {
        var text_name = $('#name').val();
        var text_phone = $('#mobile').val();
        if (text_name == '') {
            alert('请输入姓名');
            return false;
        }
        var gender= $('input:radio[name="item[sex]"]:checked').val();
        if(gender==null){
            alert("请选择性别!");
            return false;
        }
        var rec_mobiel = /^1[0-9]{2}[0-9]{8}$/;
        if (text_phone == '') {
            alert('请输入手机号');
            return false;
        } else if (!rec_mobiel.test(text_phone)){
            alert('输入的手机号格式不正确');
            return false;
        }
		
		var rec_files = /[^\x00-\xff]/;//双字节字符，含中文
		
         <?
        if(!$v['memberinfo']['photo']){
        ?>
        var files1 = $("#up_img1").prop('files');//获取到文件列表
        if(files1.length <=0){
            alert("请上传证件照片!");
            return false;
        }else if(files1[0].size > max_size){
                alert('证件照文件大小不能超过3M');
                return false;
        }
        <?
        }
        ?>
        <?
        if(!$v['memberinfo']['certificate_img']){
        ?>
        var files2 = $("#up_img2").prop('files');//获取到文件列表
        if(files2.length <=0){
            alert("请上传毕业证书扫描件!");
            return false;
        }else if(files2[0].size > max_size){
                alert('毕业证书扫描文件大小不能超过3M');
                return false;
        }
        <?
        }
        ?>
        <?
        if(!$v['memberinfo']['card_img1']){
        ?>
        var files3 = $("#up_img3").prop('files');//获取到文件列表
        if(files3.length <=0){
            alert("请上传身份证正面扫描件!");
            return false;
        }else if(files3[0].size > max_size){
                alert('身份证正面扫描件文件大小不能超过3M');
                return false;
        }
        <?
        }
        ?>
                
        <?
        if(!$v['memberinfo']['card_img2']){
        ?>
        var files4 = $("#up_img4").prop('files');//获取到文件列表
        if(files4.length <=0){
            alert("请上传身份证反面扫描件!");
            return false;
        }else if(files4[0].size > max_size){
                alert('身份证反面扫描件大小不能超过3M');
                return false;
        }
        
        <?
        }
        ?>
		
        //文件名不含中文检查
        var fn1_arr=$("#up_img1").val().split('\\');//注split可以用字符或字符串分割 
        var fn1=fn1_arr[fn1_arr.length-1];//这就是要取得的图片名称 
        if (rec_files.test(fn1)){
            alert('证件照请用英文或数字命名：'+fn1);
            return false;
       	}
        var fn2_arr=$("#up_img2").val().split('\\');//注split可以用字符或字符串分割 
        var fn2=fn2_arr[fn2_arr.length-1];//这就是要取得的图片名称 
        if (rec_files.test(fn2)){
            alert('毕业证书请用英文或数字命名：'+fn2);
            return false;
       	}
        var fn3_arr=$("#up_img3").val().split('\\');//注split可以用字符或字符串分割 
        var fn3=fn3_arr[fn3_arr.length-1];//这就是要取得的图片名称 
        if (rec_files.test(fn3)){
            alert('身份证正面图请用英文或数字命名：'+fn3);
            return false;
       	}
        var fn4_arr=$("#up_img4").val().split('\\');//注split可以用字符或字符串分割 
        var fn4=fn4_arr[fn4_arr.length-1];//这就是要取得的图片名称 
        if (rec_files.test(fn4)){
            alert('身份证反面图请用英文或数字命名：'+fn4);
            return false;
       	}
		
		//文件检查大小
               	var obj_file = document.getElementById("up_img1");  
                var filesize = 0;  
                if(browserCfg.firefox || browserCfg.chrome ){  
                    filesize = obj_file.files[0].size;  
                }else if(browserCfg.ie){  
                    var obj_img = document.getElementById('tempimg');  
                    obj_img.dynsrc=obj_file.value;  
                    filesize = obj_img.fileSize;  
                }else{  
                    alert(tipMsg);  
                	return;  
                }  
                if(filesize==-1){  
                    alert(tipMsg);  
                    return;  
                }else if(filesize>maxsize){  
                    alert("上传的证件照片文件不能超过2M");  
                    return false;  
                }
		//文件检查大小end
		
		$("#loadtip").css('display','block'); 
		$("#regtip").css('display','none'); 
		//$('.loadtip').
    })
</script>
</body>
</html>