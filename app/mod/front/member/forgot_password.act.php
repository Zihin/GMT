<?php
/***************************************************************
 * 显示首页
 *
 * @author yeahoo2000@163.com
 ***************************************************************/
class Forgot_password extends Page {
    var $AuthLevel= ACT_OPEN;
    var $db;
    var $tab = "member";
    function __construct() {
        parent :: __construct();
        $this->tab = TB_PREFIX.$this->tab;
        $this->db= Core :: getDb();
        //$this->db->debug= true;
    }
    function process() {
        $this->input = trimArr($this->input);
        $data = $this->input['item'];
        if(!$this->input['submit']){
            $this->showForm($data);
            return;
        }
        if($eMsg = $this->validate($data)){
            //vardump($eMsg);
            $this->showform($data,$eMsg);
            return;
        }
        $this->get_password($data['email']);

    }

    function get_password($email){
        global $conf;
        $password = plugin('rand_string','6','1234567890');
        $data['passwd'] =  md5($password);
         $sql = "select * from ".$this->tab." where email='".$email."'";
        $rs = $this->db->Execute($sql);
        $sql = $this->db->GetUpdateSQL($rs,$data);
        if($this->db->Execute($sql)){
            
            try {
                $mail = Core::getMailer();
                $to = $email;
                $mail->AddReplyTo($conf['smtp']['from'], "GMT");
                $mail->AddAddress($to);
                $mail->Subject = 'GMT找回密码';
                $mail->CharSet = "utf-8";
                $mail->Body = <<<EOT
<h1>尊敬的GMT用户，您的密码已经初始化为{$password}，请登录！</h1>
EOT;

                $mail->AltBody =  strip_tags($mail->Body);//当邮件不支持html时备用显示，可以省略
                $mail->WordWrap = 80; // 设置每行字符串的长度
//$mail->AddAttachment("f:/test.png"); //可以添加附件
                $mail->IsHTML(true);
                $mail->Send();
                $link = array(
                    '请登录' => 'index.php?default,login'
                );
                Core::raiseMsg('密码已经发送的您的邮箱，请查收!',$link);
                //vardump($mail);
            }catch (phpmailerException $e){

                Core::raiseMsg('密码发送失败，请联系网站管理员!');

            }
        }

    }
    /**
     * 檢查密保邮箱是否存在
     * @param string $username 會員名
     * @return int 存在的量
     */
    function isExist($email){
        $sql = "select count(*) from ".$this->tab." where email='$email'";
        return $this->db->GetOne($sql);
    }
    /**
     * 檢查輸入數據的完整性
     * @param array $data 會員輸入的數據
     * @return array $eMsg 錯誤信息字符串
     */
    function validate($data){
        $eMsg = array();
        if(!$data['email']){
            $eMsg['email'] = '密保邮箱不能为空';
        }else if(!$this->isExist($data['email'])){
            $eMsg['email'] = '该密保邮箱不存在,请重新输入';
        }else if(!plugin('is_email',$data['email'])){
            $eMsg['email'] = '密保邮箱格式不正确，请重新输入';
        }
        if(GD_ENABLE && strtolower($data['dyncode']) != strtolower($this->sess->get('dyncode'))){
            $eMsg['dyncode'] = '你输入的动态码不正确';
        }
        return renderMsg($eMsg);
    }
    /**
     * 顯示操作頁面
     * @param array $data 預填數據
     * @param array $eMsg 數據錯誤信息
     */
    function showForm($data,$eMsg=null){

        $pvar['form_act'] = Core::getUrl();
        $pvar['item'] = $data;
        $pvar['emsg'] = $eMsg;
        $pvar['goback'] = Core::getUrl('index');
        $pvar['dyncode_img'] = Core::getUrl('dyncodeImg','default');
        $pvar['self_id'] = 'index';
        $this->addTplFile('forgot_password');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }
}
?>
