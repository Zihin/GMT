<?php
/***************************************************************
 * 教师升级
 *
 ***************************************************************/
include_once LIB_DIR.'/common/formelem.php';
include_once LIB_DIR.'/common/upload.php';

class MebUpdate extends Page{
    var $AuthLevel = ACT_NEED_LOGIN;
    var $db;
    var $tab = "member";

    function __construct(){
        parent::__construct();
        $this->tab = TB_PREFIX.$this->tab;

        $this->uid = $this->sess->getUserId();
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
        if(!$this->update($data)){
            Core::raiseMsg('操作失败!,原因未知...');
        }
        Core::redirect(Core::getUrl('', ''));
    }

    /**
     * 往數據庫插入一條會員帳號資料
     * @param array $data 帳號資料
     */
    function update($data){
        unset($data['id']);
        $data['is_apply'] = 1;
        //$data['program'] = serialize($data['program']);
        //图片处理
        if($this->input['photo']['name']) {
            $upload = new PicUpload($this->input['photo'], ROOT . '/' . UPLOAD_DIR);
            $data['photo'] = $upload->upload();
        }else{
            unset($data['photo']);
        }
        if($this->input['certificate_img']['name']){
            $upload2 = new PicUpload($this->input['certificate_img'], ROOT . '/' . UPLOAD_DIR);
            $data['certificate_img'] = $upload2->upload();
         }else{
            unset($data['certificate_img']);
        }
        if($this->input['card_img1']['name']) {
            $upload3 = new PicUpload($this->input['card_img1'], ROOT . '/' . UPLOAD_DIR);
            $data['card_img1'] = $upload3->upload();
         }else{
            unset($data['card_img1']);
        }
        if($this->input['card_img2']['name']) {
            $upload3 = new PicUpload($this->input['card_img2'], ROOT . '/' . UPLOAD_DIR);
            $data['card_img2'] = $upload3->upload();
        }else{
            unset($data['card_img2']);
        }

        $sql = "select * from ".$this->tab." where id='".$this->uid."'";
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
        return renderMsg($eMsg);
    }
    /**
     * 读取待修改记录的数据
     */
    function getData(){
        $sql = "select * from ".$this->tab." where id=$this->uid";
        $data = $this->db->GetRow($sql);
        $data['gid'] = $this->sess->get('groupname');
        $data['reg_date'] = date('Y-m-d',$data['reg_date']);
        $data['discount'] = ($this->sess->get('discount') * 100)."%";
        $data['photo'] = str_replace('\\', '/', $data['photo']);
        $data['certificate_img'] = str_replace('\\', '/', $data['certificate_img']);
        $data['card_img1'] = str_replace('\\', '/', $data['card_img1']);
        $data['card_img2'] = str_replace('\\', '/', $data['card_img2']);
        return $data;
    }
    /**
     * 顯示操作頁面
     * @param array $data 預填數據
     * @param array $eMsg 數據錯誤信息
     */
    function showForm($data,$eMsg=null){

        $pvar['form_act'] = Core::getUrl();
        $pvar['memberinfo'] = $this->getData();
        $sex = empty($data['sex']) ? $pvar['memberinfo']['sex'] : $data['sex'];
        $data['gender'] = Form::sex('item[sex]',$sex);

        $pvar['item'] = $data;
        $pvar['emsg'] = $eMsg;
        $pvar['goback'] = Core::getUrl('index');
        $pvar['self_id'] = 'mebupdate';
        $pvar['nav_id'] = 'member';
        $this->addTplFile('mebupdate');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }
}
?>
