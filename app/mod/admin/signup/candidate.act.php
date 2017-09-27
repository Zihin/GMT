<?php
/***************************************************************
 * 查看会员列表
 *
 * @author Aling Xiao
 ***************************************************************/
include_once LIB_DIR . '/common/pager.php';

class Candidate extends Page{
    var $db;
    var $row = 20;
    var $currentPage = 0;
    var $queryData = array();
    var $tab = "candidate";

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
        $pvar['kw']['kw_sure_name'] = $this->input['kw_sure_name'];
        $pvar['kw']['kw_given_name'] = $this->input['kw_given_name'];
        $pvar['kw']['kw_username'] = $this->input['kw_username'];
        $pvar['kw']['kw_email'] = $this->input['kw_email'];
        $pvar['kw']['row'] = $this->row;
        $pvar['kw']['page'] = $this->currentPage;
        $sqlWhere = " where 1";
        $sqlWhere .= strlen($this->input['kw_sure_name'])?" and c.sure_name like('%{$this->input['kw_sure_name']}%')":'';
        $sqlWhere .= strlen($this->input['kw_given_name'])?" and c.given_name like('%{$this->input['kw_given_name']}%')":'';
        $sqlWhere .= strlen($this->input['kw_username'])?" and m.username like('%{$this->input['kw_username']}%')":'';
        $sqlWhere .= strlen($this->input['kw_email'])?" and c.email like('%{$this->input['kw_email']}%')":'';
        $sqlOrder = " order by c.id desc";
        $sql = "select m.username,c.* from ".$this->tab." c left join ".TB_PREFIX."member m on m.id=c.mid";
        $rs = $this->db->SelectLimit($sql.$sqlWhere.$sqlOrder,$this->row,$this->row * $this->currentPage);
        if(!$rs->RecordCount() && $this->currentPage !=0){
            //将第一页的记录显示出来
            $this->currentPage = 0;
            $rs = $this->db->SelectLimit($sql,$this->row,$this->row * $this->currentPage);
        }
        while(!$rs->EOF){
            $rs->fields['put_time'] = date(DATE_FORMAT,$rs->fields['put_time']);
            $rs->fields['btns'] = $this->btnView($rs->fields['id']).$this->btnDel($rs->fields['id']);
            $pvar['list'][]=$rs->fields;
            $rs->MoveNext();
        }
        $this->sess->setQueryData($pvar['kw']);
        if ($rs->RecordCount()) {
            $totalRecord = $this->db->GetOne(preg_replace('|^SELECT.*FROM|i', 'SELECT COUNT(*) as total FROM', $sql.$sqlWhere));
            $pvar['page_index'] = pageIndex(Core::getUrl('','','',true), $totalRecord, $this->currentPage, $this->row);
        }
        $pvar['title'] = '考生信息列表';
        $pvar['form_act'] = Core::getUrl('','','',true);
        $pvar['mul_op'] = $this->btnMop();
        $this->addTplFile('candidate');
        $this->assign(stripQuotes($pvar));
        $this->display();
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
    function btnView($id){
        return "<a href=\"javascript:location.replace('".Core::getUrl('candidateview','',array('id'=>$id))."');\">查看</a>";
    }
    function btnDel($id){
        $msg = '你确定要删除吗？';
        $url = Core::getUrl('del','',array('id'=>$id));
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
					f.action='".Core::getUrl('del','','',true)."';
					f.submit();
				}
			}
			
		}
		</script>";
        return "$js_code<select name='mop' onChange=\"mulop(this.value);\">\n$options</select>";
    }
}
?>
