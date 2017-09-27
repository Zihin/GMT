<?php
/***************************************************************
 * 增加會員
 *
 * @author yeahoo2000@163.com
 ***************************************************************/
include_once LIB_DIR.'/common/formelem.php';

class Reg extends Page{
    var $AuthLevel = ACT_OPEN;
    var $db;
    var $tab = "member";

    function __construct(){
        parent::__construct();
        $this->tab = TB_PREFIX.$this->tab;

        $this->db = Core::getDb();
        //$this->db->debug = true;
    }
    function process(){

        $this->input = trimArr($this->input);
        $data = $this->input['item'];
        if(!$this->input['submit']){
            $this->showForm($data);
            return;
        }
        if($eMsg = $this->validate($data)){
            $this->showform($data,$eMsg);
            return;
        }
        if(!$this->insert($data)){
            Core::raiseMsg('操作失败!,原因未知...');
        }
        Core::raiseMsg('恭喜你!你的帐号已成功建立!',array('回到首页'=>Core::getUrl('index')));
    }

    /**
     * 檢查會員名是否存在
     * @param string $username 會員名
     * @return int 存在的量
     */
    function isExist($username){
        $sql = "select count(*) from ".$this->tab." where username='$username'";
        return $this->db->GetOne($sql);
    }
    /**
     * 檢查密保邮箱是否存在
     * @param string $username 會員名
     * @return int 存在的量
     */
    function isEmailExist($email){
        $sql = "select count(*) from ".$this->tab." where email='$email'";
        return $this->db->GetOne($sql);
    }

    /**
     * 往數據庫插入一條會員帳號資料
     * @param array $data 帳號資料
     */
    function insert($data){
        unset($data['id']);
        $data['actived'] = 1;
        $data['member_code'] = 'MEB'.date('Ymd').plugin('rand_string',4,'0123456789');
        $data['reg_date'] = time();
        $data['passwd'] = md5($data['passwd']);
        $data['reg_ip'] = clientIp();

        $sql = "select * from ".$this->tab." where id=-1";
        $rs = $this->db->Execute($sql);
        $sql = $this->db->GetInsertSQL($rs,$data);
        return $this->db->Execute($sql);
    }

    /**
     * 檢查輸入數據的完整性
     * @param array $data 會員輸入的數據
     * @return array $eMsg 錯誤信息字符串
     */
    function validate($data){
        $eMsg = array();
        if(!$data['username']){
            $eMsg['username'] = '登录名不能为空';
        }else if($this->isExist($data['username'])){
            $eMsg['username'] = '该登录名已经存在,请重新输入';
        }else if(!plugin('is_email',$data['username']) && !plugin('is_mobile',$data['username'])){
            $eMsg['username'] = '用户名是手机号码或者邮箱';
        }

        if(!$data['email']){
            $eMsg['email'] = '密保邮箱不能为空';
        }else if($this->isEmailExist($data['email'])){
            $eMsg['email'] = '该密保邮箱存在,请重新输入';
        }else if(!plugin('is_email',$data['email'])){
            $eMsg['email'] = '密保邮箱格式不正确，请重新输入';
        }

        if(!$data['passwd']){
            $eMsg['passwd'] = '密码不能为空';
        }
        if(strlen($data['passwd'])){
            if($data['passwd'] != $data['passwd1']){
                $eMsg['passwd1'] = '你两次输入的密码不一不致';
            }
        }

        if(GD_ENABLE && strtolower($data['dyncode']) != strtolower($this->sess->get('dyncode'))){
            $eMsg['dyncode'] = '你输入的动态码不正确';
        }
//        if(strlen($data['email']) && !plugin('is_email',$data['email'])){
//            $eMsg['email'] = '你的输入的email的格式不正确';
//        }
//        if(!$data['name']){
//            $eMsg['name'] = '请输入你的真实姓名';
//        }
//        if(!$data['phone']){
//            $eMsg['phone'] = '请填写你的电话号码,以便我们在必要时可及时与你取得联系';
//        }
//        if(!$data['addr']){
//            $eMsg['addr'] = '请填写你的联系地址';
//        }
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

        $this->addTplFile('reg');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }
}
?>
