<?php
/***************************************************************
 * ¼ì²éÖ§¸¶×´Ì¬
 *
 ***************************************************************/
class Checkpay extends Action{
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
        $result = array("status"=>0);
        $sql = "select * from ".TB_PREFIX."candidate_test where id='".$this->input['test_id']."'";
        $data2 = $this->db->GetRow($sql);
        if($data2['is_pay']==1){
            $result["status"] = 1;
        }
        die(json_encode($result));

    }
}
?>