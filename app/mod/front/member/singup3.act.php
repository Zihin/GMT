<?php
/***************************************************************
 * 支付成功页面
 *
 ***************************************************************/
class Singup3 extends Page {
    var $AuthLevel= ACT_OPEN;
    var $db;
    function __construct() {
        parent :: __construct();
        require_once LIB_DIR.'/common/category.php';
        $this->db= Core :: getDb();
        //$this->db->debug= true;
    }
    function process() {
        $test_no = $this->input['test_no'];
        $sql = "select * from ".TB_PREFIX."candidate_test where test_no='".$test_no."' and is_pay = 1";
        $data2 = $this->db->GetRow($sql);
        if($data2) {
            $sql = "select * from " . TB_PREFIX . "candidate where mid = '" . $this->sess->getUserId() . "' and id='" . $data2['candidate_id'] . "'";
            $data = $this->db->GetRow($sql);
        }
    if($data2 && $data) {
        $pvar['info'] = array_merge($data, $data2);
    }

        $pvar['self_id'] = 'singup';
        $pvar['test_no'] = 'test_no';
        $this->addTplFile('singup3');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }

}
?>
