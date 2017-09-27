<?php
/***************************************************************
 * 报名
 *
 ***************************************************************/
include_once LIB_DIR.'/common/formelem.php';
include_once LIB_DIR.'/common/upload.php';
include_once LIB_DIR.'/common/category.php';

class SingUp extends Page{
    var $AuthLevel = ACT_NEED_LOGIN;
    var $db;
    var $tab = "candidate";

    function __construct(){
        parent::__construct();
        $this->tab = TB_PREFIX.$this->tab;

        $this->db = Core::getDb();
        //$this->db->debug = true;
    }
    function process(){
        $this->input = trimArr($this->input);
        if($this->input['step'] == 2){

            $this->showFormStep2();
            exit;
        }
        if(!$this->input['submit']){
            $this->showForm($this->input);
            return;
        }
        if($eMsg = $this->validate($this->input)){
            $this->showform($this->input,$eMsg);
            return;
        }
        $candidate_info = $this->get_candidate_info();
        $test = $this->input['test'];
        if($this->sess->getGroupId() == 1 && $candidate_info){
            $test['candidate_id'] = $candidate_info['id'];
            $test['stu_name'] = trim($candidate_info['sure_name']).trim($candidate_info['given_name']);
        }else {
            $this->insert($this->input['item']);
            $test['candidate_id'] = $this->db->Insert_ID();
            $test['stu_name'] = trim($this->input['item']['sure_name']).trim($this->input['item']['given_name']);

        }
        if($this->insert_test($test)) {
            $test_id = $this->db->Insert_ID();
            Core::redirect(Core::getUrl('singup', 'member', array('test_id' => $test_id,'paymethod'=>$this->input['item']['paymethod'], 'step' => 2)));
        }else{

        }
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
     * 往數據庫插入一條會員帳號資料
     * @param array $data 帳號資料
     */
    function insert($data){
        unset($data['id']);
        $data['mid'] =  $this->sess->getUserId();
        //$data['program'] = serialize($data['program']);
        //图片处理
		vardump($this->input);
        if($this->input['photo']['name']) {
            $upload = new PicUpload($this->input['photo'], ROOT . '/' . UPLOAD_DIR);
            $data['photo'] = $upload->upload();
        }
        if($this->input['passport_img1']['name']){
            $upload2 = new PicUpload($this->input['passport_img1'], ROOT . '/' . UPLOAD_DIR);
            $data['passport_img1'] = $upload2->upload();
        }
        if($this->input['passport_img2']['name']) {
            $upload3 = new PicUpload($this->input['passport_img2'], ROOT . '/' . UPLOAD_DIR);
            $data['passport_img2'] = $upload3->upload();
       }
        $data['put_time'] = time();

        $sql = "select * from ".$this->tab." where id=-1";
        $rs = $this->db->Execute($sql);
        $sql = $this->db->GetInsertSQL($rs,$data);
        return $this->db->Execute($sql);
    }

    /**
     * @param $data
     * @return mixed
     */
    function insert_test($data){
        unset($data['id']);
        $data['mid'] =  $this->sess->getUserId();
        $cate = Category::getData($data['test_center']);
        $data['test_center'] = $cate['title_zh'];
        //价格加上快递费和翻译费
        $config_data = plugin('getconfig');
        if($data['is_express'] == 1){
            $data['price'] += $config_data['express_price'];
        }

        if($data['is_interpreter'] == 1){
            $data['price'] += $config_data['interpreter_price'];
        }
        $data['test_no'] = 'GMT'.date('Ymd').plugin('rand_string',4,'0123456789');
        $data['program'] = serialize($data['program']);
        $data['put_time'] = time();

        $sql = "select * from ".TB_PREFIX."candidate_test where id=-1";
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
        /*if(!$data['test']['test_center']){
            $eMsg['test_center'] = '请选择考试中心';
        }
        if(!$data['test']['subject']){
            $eMsg['subject'] = '请选择考试科目';
        }
        if(!$data['test']['grade']){
            $eMsg['grade'] = '请选择考试级别';
        }
        if(!$data['test']['exam_time']){
            $eMsg['exam_time'] = '请选择考试时间';
        }
        if(strlen($data['test']['is_express'])<0){
            $eMsg['is_express'] = '请选择是否需要快递证书';
        }
        if(strlen($data['test']['is_interpreter'])<0){
            $eMsg['is_interpreter'] = '请选择是否需要翻译';
        }
        if(!$data['item']['sure_name']){
            $eMsg['sure_name'] = '请填写姓氏';
        }
        if(!$data['item']['given_name']){
            $eMsg['given_name'] = '请填写名字';
        }
        if(!$data['item']['birthday']){
            $eMsg['birthday'] = '请填写出生日期';
        }
        if(!strlen($data['item']['gender'])<0){
            $eMsg['gender'] = '请选择性别';
        }
        if(!plugin('is_passport_no',$data['item']['passport_no'])){
            $eMsg['passport_no'] = '你的输入的身份证/护照号码的格式不正确';        
        }
        if(!$data['item']['nationality']){
            $eMsg['gender'] = '请填写国籍';
        }
        if(!plugin('is_tel',$data['item']['tel'])){
            $eMsg['tel'] = '你的输入的电话号码的格式不正确';
        }
        if(!plugin('is_email',$data['item']['email'])){
            $eMsg['email'] = '你的输入的email的格式不正确';
        }
        
        if(!$data['item']['address']){
            $eMsg['address'] = '请填写联系地址';
        }
        if(!$data['item']['paymethod']){
            $eMsg['paymethod'] = '请选择支付方式';
        }*/
        return renderMsg($eMsg);
    }

    /**
     * 获取考试信息
     */
    function get_test_info(){
        $sql = "select * from ".TB_PREFIX."test where state=1 order by id desc";
        $rs = $this->db->GetAll($sql);
        $test_info = array();
        foreach($rs as $key => $val){
            $test_info['test_name'][$val['id']] = $val['test_name'];
            $test_info['subject'][$val['id']] = $val['subject'];
            $test_info['grade'][$val['id']] = unserialize($val['grade']);
            $test_info['exam_time'][$val['id']] = explode('#',$val['exam_time']);
        }
        return $test_info;
    }

    /**
     * 获得考生信息
     */
    function get_candidate_info(){
        $sql = "select * from ".TB_PREFIX."candidate where mid = '".$this->sess->getUserId()."'";
        return $this->db->GetRow($sql);
    }
    /**
     *
     */
    function showFormStep2(){

        $sql = "select * from ".TB_PREFIX."candidate_test where id='".$this->input['test_id']."'";
        $data2 = $this->db->GetRow($sql);
        $sql = "select * from ".TB_PREFIX."candidate where mid = '".$this->sess->getUserId()."' and id='".$data2['candidate_id']."'";
        $data = $this->db->GetRow($sql);
        //导入支付类
        include_once LIB_DIR.'/payment/'.$this->input['paymethod'].'.php';
        $obj_pay = new $this->input['paymethod'];
        $weixin_goods = $data2['subject'].$data2['grade'].'级';
        $order = array(
            'order_id' => $data2['id'],
            'weixin_goods' => $weixin_goods,
            'order_sn'=>$data2['test_no'],
            'order_amount'=>$data2['price']
        );
        $pvar['payform'] =$obj_pay->get_code($order);
        $pvar['info'] = array_merge($data,$data2);
        $pvar['test_id'] = $this->input['test_id'];
        $pvar['self_id'] = 'singup';
        $this->addTplFile('singup2');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }
    /**
     * 顯示操作頁面
     * @param array $data 預填數據
     * @param array $eMsg 數據錯誤信息
     */
    function showForm($data_info,$eMsg=null){

        $pvar['form_act'] = Core::getUrl();
        $test_info = $this->get_test_info();
        $pvar['test_name'] = $test_info['test_name'];
        $pvar['grade'] = $test_info['grade'];
        $pvar['subject'] = $test_info['subject'];
        $pvar['exam_time'] = $test_info['exam_time'];

        $is_express = empty($data_info['test']['is_express']) && $data_info['test']['is_express']==''? $pvar['candidate_info']['is_express'] : $data_info['test']['is_express'];
        $data['is_express'] = Form::radioyn('test[is_express]',$is_express);
        $is_interpreter = empty($data_info['test']['is_interpreter'])&& $data_info['test']['is_interpreter']==''? $pvar['candidate_info']['is_interpreter'] : $data_info['test']['is_interpreter'];
        $data['is_interpreter'] = Form::radioyn('test[is_interpreter]',$is_interpreter);

        // $data['test_center'] = Form::select('test[test_center]',$GLOBALS['test_center'],$data['test_center']);
        $data['test_center'] = Category::selector_c(3,'test[test_center]','test_center',$data_info['test']['test_center'],true,'',false);
        if($this->sess->getGroupId() == 1){
            $pvar['candidate_info'] = $this->get_candidate_info();
            $gender = empty($data_info['item']['gender'])  && $data_info['test']['gender']==''? $pvar['candidate_info']['gender'] : $data_info['item']['gender'];
            if($pvar['candidate_info']) {
                $pvar['is_disabled'] = 'readonly="readonly"';
            }
        }else{
            $gender = $data_info['item']['gender'];
            $pvar['is_disabled'] = 0;
        }
        $data['gender'] = Form::sex('item[gender]',$gender);
        $pvar['item'] = $data;
        $pvar['info'] = $data_info;
        $pvar['emsg'] = $eMsg;
        $pvar['goback'] = Core::getUrl('index');
        $pvar['self_id'] = 'singup';
        $this->addTplFile('singup');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }
}
?>
