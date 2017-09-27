<?php
/***************************************************************
 * 查询证书
 *
 ***************************************************************/

class Cert extends Page{
    var $AuthLevel = ACT_OPEN;
    var $db;
    var $tab = "candidate_test";

    function __construct(){
        parent::__construct();
        $this->tab = TB_PREFIX.$this->tab;

        $this->uid = $this->sess->getUserId();
        $this->db = Core::getDb();
        //$this->db->debug = true;
    }
    function process(){
        $this->input = trimArr($this->input);
        if(!$this->input['submit']){
            $this->showForm();
            return;
        }
        $sql = "select * from ".$this->tab." where test_no='".$this->input['test_no']."' and stu_name = '".$this->input['stu_name'].$this->input['given_name']."'";
        $data = $this->db->GetRow($sql);
        if($data) {
            $data['test_time'] = $data['test_time'] ? $data['test_time'] : '暂未设置考试时间';
        }
        $pvar['test_info'] = $data;
        $pvar['result'] = 1;
        $pvar['self_id'] = 'cert';
        $pvar['nav_id'] = 'gmt';
        $this->addTplFile('cert');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }

    /**
     * 顯示操作頁面
     */
    function showForm(){
        $pvar['form_act'] = Core::getUrl();;
        $pvar['self_id'] = 'cert';
        $pvar['nav_id'] = 'gmt';
        $this->addTplFile('cert');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }
}
?>
