<?php
/***************************************************************
 * 打印考试信息
 *
 * @author ALing Xiao
 ***************************************************************/
include_once LIB_DIR.'/common/pager.php';
class PrintTest extends Page{
    var $AuthLevel = ACT_NEED_LOGIN;
    var $db;
    var $tab = 'candidate_test';

    function __construct(){
        parent::__construct();
        $this->tab = TB_PREFIX.$this->tab;

        $this->uid = $this->sess->getUserId();
        $this->db = Core::getDb();
    }
    function process(){
        include_once LIB_DIR."/common/category.php";
        include_once LIB_DIR."/common/contentpart.php";
        $id = $this->input['id'];
        $part = $this->input['part'];
        if(!is_numeric($id)){
            Core::raiseMsg('参数错误,没有指定有效的ID�?');
        }
        $sql = "select * from $this->tab where id=$id";
        $data['test'] = $this->db->GetRow($sql);
        if(!$data['test']['test_time']) {
            $data['test']['test_time'] = '<font color="red">具体时间待确认</font>';
        }
        if(!count($data['test'])){
            Core::raiseMsg('页面不存在或者已被删?...');
        }
        $data['member'] =  $this->getMemberInfo();
        $data['candidate'] =  $this->getCandidate($data['test']['candidate_id']);
        $this->addTplFile('print');
        $this->assign(stripQuotes($data));
        $this->display();
    }
    /**
     * 读取会员信息
     */
    function getMemberInfo(){
        $sql = "select * from ".TB_PREFIX."member where id=$this->uid";
        $data = $this->db->GetRow($sql);
        $data['gid'] = $this->sess->get('groupname');
        $data['reg_date'] = date('Y-m-d',$data['reg_date']);
        return $data;
    }
    /**
     * 读取考生信息
     */
    function getCandidate($candidate_id){
        if($candidate_id){
            $sql = "select * from ".TB_PREFIX."candidate where id=$candidate_id";
            $data = $this->db->GetRow($sql);
            $data['gender'] = $data['gender'] == 1 ? 'Female女' : 'Male男';
        }
        return $data;
    }
}
?>