<?php
/***************************************************************
 * 教师升级
 *
 ***************************************************************/

class Search extends Page{
    var $AuthLevel = ACT_OPEN;
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
        if(!$this->input['submit']){
            $this->showForm();
            return;
        }
        $sql = "select * from ".$this->tab." where name='".$this->input['username_t']."' and member_code = '".$this->input['member_code_t']."'";
        $data = $this->db->GetRow($sql);
        if($data) {
            $data['type'] = $data['gid'] == 1 ? '普通会员' : '教师会员';
            $gInfo = $this->db->GetRow("select title,discount from ".TB_PREFIX."mb_group where id={$data['gid']}");
            $data['groupname'] = $gInfo['title'];
            $data['reg_date'] = date('Y-m-d', $data['reg_date']);
        }
        $pvar['meb_info'] = $data;
        $pvar['result'] = 1;
        $pvar['self_id'] = 'search';
        $pvar['nav_id'] = 'member';
        $this->addTplFile('search');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }

    /**
     * 顯示操作頁面
     */
    function showForm(){
        $pvar['form_act'] = Core::getUrl();;
        $pvar['self_id'] = 'search';
        $pvar['nav_id'] = 'member';
        $this->addTplFile('search');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }
}
?>
