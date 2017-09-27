<?php
/***************************************************************
 * 增加會員
 *
 * @author yeahoo2000@163.com
 ***************************************************************/
include_once LIB_DIR.'/common/formelem.php';

class Singup4 extends Page{
    var $AuthLevel = ACT_NEED_LOGIN;
    var $db;
    var $tab = "candidate_test";

    function __construct(){
        parent::__construct();
        $this->tab = TB_PREFIX.$this->tab;

        $this->db = Core::getDb();
        //$this->db->debug = true;
    }
    function process(){

        $this->input = trimArr($this->input);
        $data = $this->input['item'];

        $id = is_numeric($this->input['id'])? $this->input['id'] : $data['id'];
        if(!is_numeric($id)){
            Core::raiseMsg('错误!没有指定ID号');
        }
        $data['id'] = $id;

        if(!$this->input['submit']){
            $this->showForm($data);
            return;
        };
        if($eMsg = $this->validate($data)){
            $this->showform($data,$eMsg);
            return;
        }
        if(!$this->updateDb($id,$data)){
            Core::raiseMsg('操作失败!,原因未知...');
        }
        Core::redirect(Core::getUrl('singup', 'member', array('test_id' => $id,'paymethod'=>$data['paymethod'], 'step' => 2)));
    }

    /**
     * 更新支付方式
     * @param array $data 帳號資料
     */
    function updateDb($id,$data){
        unset($data['id']);	//防止ID号被修
        $sql = "select * from ".$this->tab." where id=$id";
        $rs = $this->db->Execute($sql);
        $sql = $this->db->GetUpdateSQL($rs,$data);
        return $this->db->Execute($sql);
    }

    /**
     * 檢查輸入數據的完整性
     * @param array $data 會員輸入的數據
     * @return array $eMsg 錯誤信息字符串
     */
    function validate($data){
        $eMsg = array();


        if(!$data['paymethod']){
            $eMsg['paymethod'] = '请选择支付方式';
        }

        return renderMsg($eMsg);
    }

    /**
     * 顯示操作頁面
     * @param array $data 預填數據
     * @param array $eMsg 數據錯誤信息
     */
    function showForm($data,$eMsg=null){
        $sql = "select * from ".TB_PREFIX."candidate_test where id='".$data['id']."'";
        $candidate_test = $this->db->GetRow($sql);
        $sql = "select * from ".TB_PREFIX."candidate where mid = '".$this->sess->getUserId()."' and id='".$candidate_test['candidate_id']."'";
        $candidate = $this->db->GetRow($sql);

        $pvar['form_act'] = Core::getUrl();
        $pvar['info'] = array_merge($candidate_test,$candidate);
        $pvar['item'] = $data;
        $pvar['emsg'] = $eMsg;
        $pvar['self_id'] = 'singup';
        $this->addTplFile('singup4');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }
}
?>
