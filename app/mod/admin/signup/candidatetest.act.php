<?php
/***************************************************************
 * 查看会员列表
 *
 * @author Aling Xiao
 ***************************************************************/
include_once LIB_DIR . '/common/pager.php';
include_once LIB_DIR.'/common/formelem.php';

class CandidateTest extends Page{
    var $db;
    var $row = 20;
    var $currentPage = 0;
    var $queryData = array();
    var $tab = "candidate_test";

    function __construct(){
        parent::__construct();
        $this->tab = TB_PREFIX.$this->tab;

        $this->db = Core::getDb();
        //$this->db->debug = true;
        $this->setRowPrePage($this->input['row']);
        $this->setCurrentPage($this->input['page']);
    }
    function process(){
        $pvar = array();
        $pvar['kw']['kw_test_center'] = trim($this->input['kw_test_center']);
        $pvar['kw']['kw_test_name'] = trim($this->input['kw_test_name']);
        $pvar['kw']['kw_stu_name'] = trim($this->input['kw_stu_name']);
        $pvar['kw']['kw_test_no'] = $this->input['kw_test_no'];
        $pvar['kw']['kw_username'] = $this->input['kw_username'];
        $pvar['kw']['mid'] = $this->input['mid'];
        if(is_numeric($this->input['kw_is_pay']))
            $pvar['kw']['kw_is_pay'] = $this->input['kw_is_pay'];
        $pvar['kw']['row'] = $this->row;
        $pvar['kw']['page'] = $this->currentPage;
        $sqlWhere = " where 1";
        $sqlWhere .= strlen($pvar['kw']['kw_is_pay']) ? " and c.is_pay = {$pvar['kw']['kw_is_pay']}" : '';
        $sqlWhere .= strlen($this->input['kw_stu_name'])?" and c.stu_name like('%{$this->input['kw_stu_name']}%')":'';
        $sqlWhere .= strlen($this->input['kw_test_center'])?" and c.test_center like('%{$this->input['kw_test_center']}%')":'';
        $sqlWhere .= strlen($this->input['kw_test_name'])?" and c.test_name like('%{$this->input['kw_test_name']}%')":'';
        $sqlWhere .= strlen($this->input['kw_test_no'])?" and c.given_name like('%{$this->input['kw_test_no']}%')":'';
        $sqlWhere .= strlen($this->input['kw_username'])?" and m.username like('%{$this->input['kw_username']}%')":'';
        $sqlWhere .= strlen($this->input['mid'])?" and c.mid = {$pvar['kw']['mid']}" :'';
        $sqlOrder = " order by c.id desc";
        $sql = "select m.username,c.* from ".$this->tab." c left join ".TB_PREFIX."member m on m.id=c.mid";
        $rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
        if(!$rs->RecordCount() && $this->currentPage !=0){
            //将第一页的记录显示出来
            $this->currentPage = 0;
            $rs = $this->db->SelectLimit($sql,$this->row,$this->row * $this->currentPage);
        }
        while(!$rs->EOF){
            $rs->fields['paystate'] = $rs->fields['is_pay']?'<img src="imgs/icon/check.gif" title="已付款">':'<img src="imgs/icon/uncheck.gif" title="未付款">';

            $rs->fields['put_time'] = date(DATE_FORMAT,$rs->fields['put_time']);
            $rs->fields['btns'] = $this->btnModify($rs->fields['id']).$this->btnViewMember($rs->fields['mid']).$this->btnDel($rs->fields['id']);
            $pvar['list'][]=$rs->fields;
            $rs->MoveNext();
        }
        if($this->input['download']==1){
            $this->export_csv($pvar['list']);
            exit;
        }
        $this->sess->setQueryData($pvar['kw']);
        if ($rs->RecordCount()) {
            $totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
            $pvar['page_index'] = pageIndex(Core::getUrl('','','',true), $totalRecord, $this->currentPage, $this->row);
        }
        $pvar['title'] = '报名信息列表';
        $pvar['form_act'] = Core::getUrl('','','',true);
        $pvar['download_url'] = Core::getUrl('','',$pvar['kw'],true);
        $pvar['mul_op'] = $this->btnMop();
        $pvar['is_pay'] = Form::select('kw_is_pay',array(''=>'', '1'=>'已付款', '0'=>'未付款'),$pvar['kw']['kw_is_pay']);
        $this->addTplFile('candidatetest');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }  
    
    function export_csv($data) {
        $filename = date('YmdHis').".csv";//文件名
        header("Content-type:text/csv; charset=utf-8");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $str = '考试名称,会员账号,考生姓名,考生编号,考生中心,科目,级别,价格,考试时间,分数,录入时间,付款状态'."\n"; //栏目名称
        foreach($data as $val){
            $is_pay = $val['is_pay']?'已付款':'未付款';
            $str .= $val['test_name'].',\''.$val['username'].','.$val['stu_name'].','.$val['test_no'].','.$val['test_center'].','.$val['subject'].','.$val['grade'].','.$val['price'].','.$val['test_time'].','.$val['score'].',\''.$val['put_time'].','.$is_pay."\n";
        }
        echo $str;
    }
    
    function setRowPrePage($row){
        if(is_numeric($row) && $row <= 100){
            $this->row = $row;
        }
    }
    function setCurrentPage($page){
        if(is_numeric($page)){
            $this->currentPage = $page;
        }
    }
    function btnModify($id){
        return "&nbsp;<a href=\"javascript:location.replace('".Core::getUrl('candidatetestupdate','',array('id'=>$id))."');\">编辑</a>";
    }

    function btnCandidate($id){
        return "&nbsp;<a href=\"javascript:location.replace('".Core::getUrl('CandidateView','signup',array('id'=>$id))."');\">查看考生信息</a>";
    }
    function btnViewMember($id){
        return "&nbsp;<a href=\"javascript:location.replace('".Core::getUrl('mbmodify','member',array('id'=>$id))."');\">查看会员</a>";
    }
    function btnDel($id){
        $msg = '你确定要删除吗？';
        $url = Core::getUrl('deltest','',array('id'=>$id));
        return " <a href=\"javascript:if(confirm('{$msg}'))location.replace('{$url}');\">删除</a>";
    }
    function btnMop(){
        $f = "";
        $options = "<option value=''>...</option>\n"
//            ."<option value='Active'>激活帐号</option>\n"
//            ."<option value='Disable'>冻结帐号</option>\n"
            ."<option value='' disabled='disabled'>------</option>\n"
            ."<option value='Del'>删除</option>\n";
        $js_code = "
		<script language='javascript'>
		var f = document.getElementById('main_form');
		function mulop(act){
			if('Active' == act){
				if(confirm('你确定要激活所有选中的会员帐号吗？')){
					f.action='".Core::getUrl('mbstate','',array('val'=>1),true)."';
					f.submit();
				}
			}
			if('Disable' == act){
				if(confirm('你确定要冻结所有选中的会员帐号吗？')){
					f.action='".Core::getUrl('mbstate','',array('val'=>0),true)."';
					f.submit();
				}
			}
			if('Del' == act){
				if(confirm('注意!该操作不可恢复.你确定要删除所有选中的会员帐号吗？')){
					f.action='".Core::getUrl('deltest','','',true)."';
					f.submit();
				}
			}
			
		}
		</script>";
        return "$js_code<select name='mop' onChange=\"mulop(this.value);\">\n$options</select>";
    }
}
?>
