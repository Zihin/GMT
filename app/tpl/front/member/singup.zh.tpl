<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>GMT-报名</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="Expires" CONTENT="0">
    <meta http-equiv="Cache-Control" CONTENT="no-cache">
    <meta http-equiv="Cache-Control" CONTENT="no-store">
    <link rel="stylesheet" href="css/gmt.css" type="text/css"/>
<!--<style type="text/css">
@import url(scripts/calendar/calendar-system.css);
</style>
<script type="text/javascript" src="scripts/calendar/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar/lang/calendar-zh.js"></script>
<script type="text/javascript" src="scripts/calendar/calendar-setup.js"></script>-->
<script src="scripts/laydate/laydate.js"></script>

</head>
<body>
<!-- 头部 -->
<?php include TPL_DIR . '/front/header.' . LANGUAGE . '.tpl'; ?>
<!-- 主体 -->
<div class="newsarea cf">
    <div class="w1140">
        <div class="newsbox l">
            <div class="content-news fl">
                <div class="box01-signin fl">
                    <ul class="signnav">
                        <li class="on">1 ｜ 提交报名</li>
                        <li>2 ｜ 在线支付</li>
                        <li class="last">3 ｜ 报名成功</li>
                    </ul>
                    <div class="importantip fl">
                        <h6><b> Important Notice 重要提示</b></h6>
                        <ul>
                            <li>Candidates aged below 18 must apply through parent/guardian, teacher or
                                school/studio.<br/> 未满18岁的考生必须由家长/监护人、老师、学校或者培训机构代为申请。
                            </li>
                            <li>All blanks should be completed unless stated otherwise. Any incomplete forms with
                                missing documents
                                will not be processed. <br/> 所有表格信息必须填写完整，未填写完整的报名表将不予受理。
                            </li>
                            <li>If you have more than 1 candidate, supplementary candidates’ details form must be
                                used.<br/>申请者若代表多位考生申请考试，每位考生需分别填写申请表。
                            </li>
                            <li>Please ensure the information supplied on the entry form is accurate; including
                                candidates’ name
                                spelling, grades and exam subjects, etc. <br/> 请确保申请表所填写的信息正确无误，包括考生的姓名、报考级数和考试科目等。
                            </li>
                            <li> Fees paid are not refundable and not transferable from one candidate to another or from
                                one
                                examination to another.<br/>报名及考试费用一旦支付，不可退还，也不可转让至另一投考者或者同一投考者的另一考试科目。
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 考试信息 -->
                <form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post" enctype="multipart/form-data">
                <div class="box01-testinfo fl">
                    <h6 class="testtip">Test Info. 考试信息</h6>
                    <ul class="testlist">
                        <li><span class="left">Test Center 考试中心：</span>

                            <div class="grp">
                                <?=$v['item']['test_center']?>
                                <?=$v['emsg']['test_center']?>
                            </div>
                        </li>

                        <li class="subject"><span class="left">Subject 科目：</span>

                            <div class="grp">
                                <?
                                 $c = 1;
                                foreach($v['subject'] as $subid => $subject)
                                {
                                    if($v['info']['test']['subject'] == $subject){
                                        $cid = $subid;
                                        $is_checked = "checked=\"checked\"";
                                      }else{
                                        $is_checked = "";
                                    }
//                                    elseif($c==1){
//                                        $is_checked = "checked=\"checked\"";
//                                    }else{
//                                        $is_checked = "";
//                                    }
                                ?>
                                <label><input name="test[subject]" class="subject" type="radio" value="<?=$subject?>" test_name="<?=$v['test_name'][$subid]?>" subid="<?=$subid?>" <?=$is_checked?> onClick="changeitem(this)"/><?=$subject?></label>
                                <?
                                $c++;
                                }
                                ?>
                                <?=$v['emsg']['subject']?>
                            </div>
                        </li>
                        <li class="grade"><span class="left">Grade 级别：</span>

                            <?
                            if(is_array($v['grade']))
                            {
                                $i = 1;
                                foreach($v['grade'] as $subid => $arrg){
                                    if($cid == $subid){
                                        $is_display = "bolck";
                                     }
                                    elseif($i==1){
                                        $is_display = "bolck";
                                    }else{
                                        $is_display = "none";
                                    }
                            ?>
                            <div class="grp gradeitem" id="grade<?=$subid?>" style="display: <?=$is_display?>">
                                <?
                                if(is_array($arrg))
                                {
                                    foreach($arrg as $k2=>$gval)
                                    {
                                        
                                    if($v['info']['test']['grade'] == $k2){
                                        $is_ck = "checked=\"checked\"";
                                    }else{
                                        $is_ck = "";
                                    }
                                ?>
                                <label><input name="test[grade]" type="radio" price="<?=$gval?>" value="<?=$k2?>" <?=$is_ck?> onClick="changeprice(this)"/><?=$k2?></label>
                                <?
                                    }
                                }
                                ?>
                                <?=$v['emsg']['grade']?>
                            </div>
                            <?
                                $i++;
                               }
                            }
                            ?>
                            <input type="hidden" name="test[price]" id="price" value="<?=$v['info']['test']['price']?>" value="0">
                            <input type="hidden" name="test[test_name]" id="test_name" value="<?=$v['info']['test']['test_name']?>" value="">
                        </li>
                        <li class="subject"><span class="left">Program 曲目：</span>

                            <div class="grp">
                                <ul class="proul">
                                    <li><input type="text" placeholder="Optional选填" name="test[program][]" value="<?=$v['info']['test']['program'][0]?>" class="text"/></li>
                                    <li><input type="text" placeholder="Optional选填" name="test[program][]" value="<?=$v['info']['test']['program'][1]?>" class="text"/></li>
                                    <li><input type="text" placeholder="Optional选填" name="test[program][]" value="<?=$v['info']['test']['program'][2]?>" class="text"/></li>
                                    <li><input type="text" placeholder="Optional选填" name="test[program][]" value="<?=$v['info']['test']['program'][3]?>" class="text"/></li>
                                </ul>
                            </div>
                        </li>
                        <li class="subtime cf"><span class="left">Exam Period 考试时间：</span>
                            <?
                            if(is_array($v['exam_time']))
                            {
                                $j = 1;
                                foreach($v['exam_time'] as $subid => $arre)
                                {
                                if($cid == $subid){
                                    $is_display = "bolck";
                                }elseif($j == 1){
                                    $is_display = "bolck";
                                }else{
                                    $is_display = "none";
                                }
                            ?>
                            <div class="grp exam" id="exam_time<?=$subid?>" style="display: <?=$is_display?>">
                                <?
                                foreach($arre as $key => $val)
                                {
                                    if($v['info']['test']['exam_time'] == $val){
                                        $is_ck = "checked=\"checked\"";
                                    }else{
                                        $is_ck = "";
                                    }
                                ?>
                                    <label><input name="test[exam_time]" type="radio" value="<?=$val?>" <?=$is_ck?>/><?=$val?></label>
                                <?
                                }
                                ?>
                                <?=$v['emsg']['exam_time']?>
                            </div>
                            <?
                                $j++;
                                }
                            }
                            ?>
                        </li>
                    </ul>
                </div>
                <!-- 考生信息 -->
                <div class="box01-cand">
                    <h6 class="testtip">Candidate’s Info. 考生信息</h6>
                    <ul class="candlist">
                        <li><span class="left">Sure Name 姓氏：</span>

                            <div class="grp"><input name="item[sure_name]" id="sure_name"
                                                    value="<?=$v['info']['item']['sure_name']?$v['info']['item']['sure_name']:$v['candidate_info']['sure_name']?>"
                                                    placeholder="请填写英文或拼音字母，例：chen" type="text" id="text_surname" class="text text_surname" <?=$v['is_disabled']?>/>
                                
                                <?=$v['emsg']['sure_name']?>
                            </div>
                        </li>
                        <li><span class="left">Given Name 名字：</span>

                            <div class="grp"><input name="item[given_name]" id="given_name"
                                                    value="<?=$v['info']['item']['given_name']?$v['info']['item']['given_name']:$v['candidate_info']['given_name']?>"
                                                    placeholder="请填写英文或拼音字母，例：xiaoming" type="text"  class="text text_name" <?=$v['is_disabled']?>/>
                            
                                <?=$v['emsg']['given_name']?>
                            </div>
                        </li>
                        <li><span class="left">Name in Chinese 中文姓名：</span>

                            <div class="grp"><input name="item[ch_name]" id="ch_name"
                                                    value="<?=$v['info']['item']['ch_name']?$v['info']['item']['ch_name']:$v['candidate_info']['ch_name']?>"
                                                    placeholder="Optional选填" type="text" class="text"
                                                    <?=$v['is_disabled']?>/></div>
                        </li>
                        <li><span class="left">Date of Birth 出生日期：</span>

                            <div class="grp"><input name="item[birthday]" id="birthday"
                                                    value="<?=$v['info']['item']['birthday']?$v['info']['item']['birthday']:$v['candidate_info']['birthday']?>"
                                                    placeholder="年-月-日" type="text"   class="text "  <?=$v['is_disabled']?>/>
                                <?=$v['emsg']['birthday']?>
								<script>
									laydate({
   										elem: '#birthday', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
    									event: 'focus' //响应事件。如果没有传入event，则按照默认的click
									});
								</script>
                            </div>
                        </li>
                        <li class="sex"><span class="left">Gender 性别：</span>

                            <div class="grp">
                                <?=$v['item']['gender']?>
                                <?=$v['emsg']['gender']?>
                            </div>
                        </li>
                        <li><span class="left">ID/Passport No. 身份证/护照号码：</span>

                            <div class="grp"><input type="text" name="item[passport_no]" id="passport_no"
                                                    value="<?=$v['info']['item']['passport_no']?$v['info']['item']['passport_no']:$v['candidate_info']['passport_no']?>"
                                                    class="text text_cardid" <?=$v['is_disabled']?>/>
                                <?=$v['emsg']['passport_no']?>
                            </div>
                        </li>
                        <li><span class="left">Nationality 国籍：</span>

                            <div class="grp"><input type="text" name="item[nationality]" id="nationality"
                                                    value="<?=$v['info']['item']['nationality']?$v['info']['item']['nationality']:$v['candidate_info']['nationality']?>"
                                                    class="text text_nation" <?=$v['is_disabled']?>/>
                            
                                <?=$v['emsg']['nationality']?>
                            </div>
                        </li>
                        <li><span class="left">Telephone No. 电话号码：</span>

                            <div class="grp"><input type="text" name="item[tel]" id="tel"
                                                    value="<?=$v['info']['item']['tel']?$v['info']['item']['tel']:$v['candidate_info']['tel']?>"
                                                    class="text text_phone" <?=$v['is_disabled']?>/>
                            
                                <?=$v['emsg']['tel']?>
                            </div>
                        </li>
                        <li><span class="left">E-mail 邮箱：</span>

                            <div class="grp"><input type="text" name="item[email]" id="email"
                                                    value="<?=$v['info']['item']['email']?$v['info']['item']['email']:$v['candidate_info']['email']?>"
                                                    class="text text_mail" <?=$v['is_disabled']?>/>
                            
                                <?=$v['emsg']['email']?>
                            </div>
                        </li>
                        <li><span class="left">Mail Address 联系地址：</span>

                            <div class="grp"><input type="text" name="item[address]" id="address"
                                                    value="<?=$v['info']['item']['address']?$v['info']['item']['address']:$v['candidate_info']['address']?>"
                                                    class="text text_address" <?=$v['is_disabled']?>/>
                                <?=$v['emsg']['address']?>
                            </div>
                        </li>
                        <li class="sex"><span class="left">Express Certificate 快递证书：</span>

                            <div class="grp">
                                <?=$v['item']['is_express']?>
                                <?=$v['emsg']['is_express']?>
                            </div>
                        </li>
                        <li class="sex"><span class="left">Interpreter Required 是否需要翻译：</span>

                            <div class="grp">
                                <?=$v['item']['is_interpreter']?>
                                <?=$v['emsg']['is_interpreter']?>
                            </div>
                        </li>
                        <li class="photo cf"><span class="left">Upload Photo 上传考生报名照：</span>

                            <div class="grp">
                                <input type="file" name="photo" class="fl" id="up_img1"/>

                                <div class="imgdiv" id="imgdiv1"></div>
                                <?
                                if($v['candidate_info']['photo']){
                                ?>
                                <img id="imgShow1" src="uploads/<?=$v['candidate_info']['photo']?>"
                                     class="previmg cf"/>
                                <?
                                }else{
                                ?>
                                <img id="imgShow1" src="images/card01.jpg" class="previmg cf"/>
                                <?
                                }
                                ?>
                            </div>
                        </li>
                        <li class="photo cf"><span class="left">Upload ID 上传考生护照/身份证/<br/>出生证明/户口本：</span>

                            <div class="grp"><input type="file" class="fl" name="passport_img1" id="up_img2"/>

                                <div class="imgdiv" id="imgdiv2"></div>
                                <?
                                if($v['candidate_info']['passport_img1']){
                                ?>
                                <img id="imgShow2" src="uploads/<?=$v['candidate_info']['passport_img1']?>"
                                     class="previmg cf"/>
                                <?
                                }else{
                                ?>
                                <img id="imgShow2" src="images/card02.jpg" class="previmg cf"/>
                                <?
                                }
                                ?>
                            </div>
                        </li>
                        <li class="photo cf"><span class="left">Upload ID 上传考生证件照反面：</span>

                            <div class="grp"><input type="file" name="passport_img2" id="up_img3" class="fl"/>

                                <div class="imgdiv" id="imgdiv3"></div>
                                <?
                                if($v['candidate_info']['passport_img2']){
                                ?>
                                <img id="imgShow3" src="uploads/<?=$v['candidate_info']['passport_img2']?>"
                                     class="previmg cf"/>
                                <?
                                }else{
                                ?>
                                <img id="imgShow3" src="images/card03.jpg" class="previmg cf"/>
                                <?
                                }
                                ?>
                            </div>
                        </li>
                        <li>
                            <span class="left">选择支付方式：</span>
                            <div class="grp">
                                <label><input type="radio" name="item[paymethod]" value="alipay" <?=$v['info']['item']['paymethod']=='alipay'?"checked=\"checked\"":""?>/><img src="images/bank/zfb.gif" align="absmiddle"/></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label ><input type="radio" name="item[paymethod]" value="upop"  <?=$v['info']['item']['paymethod']=='upop'?"checked=\"checked\"":""?>/><img src="images/bank/upop.gif" align="absmiddle"/></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input type="radio" name="item[paymethod]" value="wxpay" <?=$v['info']['item']['paymethod']=='wxpay'?"checked=\"checked\"":""?>/><img src="images/bank/pay5.gif" align="absmiddle"/></label>
                                
                                <?=$v['emsg']['paymethod']?>
                            </div>
                        </li>

                    </ul>
                    <input type="submit" name="submit" value="下一步" class="redbtn gonext" />
                    <div id="loadtip" class="regtip" style="width:700px; display:none;""><p><img src="imgs/icon/i.gif" align="absmiddle" /> 数据上传中，请耐心等候！</p></div>
                </div>
                </form>
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
    <script type="text/javascript" src="js/placeholder.js"></script>
    <script type="text/javascript">
        window.onload = function () {
            new uploadPreview({UpBtn: "up_img1", DivShow: "imgdiv1", ImgShow: "imgShow1"});
            new uploadPreview({UpBtn: "up_img2", DivShow: "imgdiv2", ImgShow: "imgShow2"});
            new uploadPreview({UpBtn: "up_img3", DivShow: "imgdiv3", ImgShow: "imgShow3"});
        }
        //提交验证
        $('.gonext').click(function () {
           var text_center = $('#test_center').val();
            var text_surname = $('#sure_name').val();
            var text_name = $('#given_name').val();
            var text_date = $('#birthday').val();
            var text_phone = $('#tel').val();
            var text_cardid = $('#passport_no').val();
            var text_nation = $('#nationality').val();
            var text_mail = $('#email').val();
            var text_address = $('#address').val();
            var subject= $('input:radio[name="test[subject]"]:checked').val();
            if(text_center=='' || text_center==null){
                alert("请选择考试中心!");
                return false;
            }
            if(subject==null){
                alert("请选择科目!");
                return false;
            }
            var grade= $('input:radio[name="test[grade]"]:checked').val();
            if(grade==null){
                alert("请选择考试级别!");
                return false;
            }

            var exam_time= $('input:radio[name="test[exam_time]"]:checked').val();
            if(exam_time==null){
                alert("请选择考试时间!");
                return false;
            }
            
            if (text_surname == '' || text_surname=='请填写姓氏大写拼音字母') {
                alert('请输入姓氏');
                return false;
            }
            if (text_name == '' || text_name == '请填写名字大写拼音字母') {
                alert('请输入姓名');
                return false;
            }
            if (text_date == '' || text_date == '年-月-日') {
                alert('请输入出生日期');
                return false;
            }
            var gender= $('input:radio[name="item[gender]"]:checked').val();
            if(gender==null){
                alert("请选择性别!");
                return false;
            }

            var rec_card = /^[0-9a-zA-Z]*$/g;
            if (text_cardid == '') {
                alert('请输入身份证或护照号码');
                return false;
             } else if (!rec_card.test(text_cardid)){
            alert('身份证或护照号码只能输入字母或者数字');
            return false;
        }
            if (text_nation == '') {
                alert('请输入国籍');
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
           var rec_emial = /^[a-z0-9_\-\.]+@[a-zZ0-9_-]+\.[a-z0-9_-]+[a-z\.]+/;
            if (text_mail == '') {
                alert('请输入邮箱');
                return false;
            } else if (!rec_emial.test(text_mail)){
                alert('输入的邮箱格式不正确');
                return false;
            }
            if (text_address == '') {
                alert('请输入联系地址');
                return false;
            }
            var is_express= $('input:radio[name="test[is_express]"]:checked').val();
            if(is_express==null){
                alert("请选择是否快递证书!");
                return false;
            }
            var is_interpreter= $('input:radio[name="test[is_interpreter]"]:checked').val();
            if(is_interpreter==null){
                alert("请选择是否需要翻译!");
                return false;
            }
            var max_size = 3*1024*1024
	    var rec_files = /[^\x00-\xff]/;//双字节字符，含中文
            var files1 = $("#up_img1").prop('files');//获取到文件列表
            
            var fn1_arr=$("#up_img1").val().split('\\');//注split可以用字符或字符串分割 
            var fn1=fn1_arr[fn1_arr.length-1];//这就是要取得的图片名称 
            if(files1.length <=0){
                alert("请上传考生报名照!");
                return false;
            } else if (rec_files.test(fn1)){
                alert('考生报名照请用英文或数字命名：'+fn1);
                return false;
            }else if(files1[0].size > max_size){
                alert('考生报名照文件大小不能超过3M');
                return false;
            }
			
			
            var files2 = $("#up_img2").prop('files');//获取到文件列表
            var fn2_arr=$("#up_img2").val().split('\\');//注split可以用字符或字符串分割 
            var fn2=fn2_arr[fn2_arr.length-1];//这就是要取得的图片名称 
            if(files2.length <=0){
                alert("请上传考生护照/身份证/出生证明/户口本!");
                return false;
            } else if (rec_files.test(fn2)){
            	alert('证件照请用英文或数字命名：'+fn2);
            	return false;
            }else if(files2[0].size > max_size){
                alert('证件照文件大小不能超过3M');
                return false;
            }
			
            var files3 = $("#up_img3").prop('files');//获取到文件列表
			var fn3_arr=$("#up_img3").val().split('\\');//注split可以用字符或字符串分割 
			var fn3=fn3_arr[fn3_arr.length-1];//这就是要取得的图片名称 
            if(files3.length <=0){
                alert("请上传考生证件照反面!");
                return false;
            } else if (rec_files.test(fn3)){
            	alert('证件照反面请用英文或数字命名：'+fn3);
            	return false;
           }else if(files3[0].size > max_size){
                alert('证件照反面文件大小不能超过3M');
                return false;
            }
            
            var paymethod= $('input:radio[name="item[paymethod]"]:checked').val();
            if (paymethod == null) {
                alert('请输选择支付方式');
                return false;
            }
			
			$("#loadtip").css('display','block'); 

        })
       function changeprice(obj){
           $('#price').val($(obj).attr('price'));
       }
        function changeitem(obj){
            var subid=$(obj).attr('subid');
            $('input:radio[name="test[grade]"]').each(function(){
                $(this).removeAttr("checked");
            });

            $('input:radio[name="test[exam_time]"]').each(function(){
                $(this).removeAttr("checked");
            });
//            $('input:radio[name="item[grade]"]').attr("checked",false);
//            $('input:radio[name="item[exam_time]"]').attr("checked",false);
            $('#price').val('');
            $('#test_name').val($(obj).attr('test_name'))
            $('.gradeitem').hide();
            $('#grade'+subid).show();
            $('.exam').hide();
            $('#exam_time'+subid).show();
        }
        $(document).ready(function(){

            $('input:radio[name="test[subject]"]').each(function(){
                var subid =$(this).attr('subid');
                if($(this).attr("checked") == "checked"){
                    $('.gradeitem').hide();
                    $('#grade'+subid).show();
                    $('.exam').hide();
                    $('#exam_time'+subid).show();
                }
            });
        });
    </script>
</body>
</html>