<?php

/* * *************************************************************
 * 上传多张图片
 * 
 * @author alen1984116@126.com
 * ************************************************************* */

class Publish extends Page {

    var $db;

    function __construct() {
        parent :: __construct();
        $this->tab = TB_PREFIX . 'images';

        $this->db = Core :: getDb();
        $this->db->debug= true;
    }

    function process() {
        $data = stripQuotes($this->input['item']);

        $data['assoc_id'] = strlen($this->input['assoc_id']) ? $this->input['assoc_id'] : $data['assoc_id'];
        $data['cate_id'] = strlen($this->input['cate_id']) ? $this->input['cate_id'] : $data['cate_id'];
        $arr_pics = $this->input['pics'];
        if (!$this->input['submit']) {
            $data['pub_time'] = date('Y-m-d');
            $this->showForm($data);
            return;
        }

        if (is_array($arr_pics)) {
            foreach($arr_pics as $v) {
                $data['pic'] = $v;
                if (!$this->insert($data)) {
                    Core::raiseMsg('操作失败!,原因未知...');
                }
            }
        
        }
        Core::redirect(Core::getUrl('showlist', 'mulupload', array('assoc_id' => $data['assoc_id'], 'cate_id' => $data['cate_id'])));
    }

    function btnShowlist($assoc_id, $cate_id) {
        $url = Core::getUrl('showlist', 'mulupload', array('assoc_id' => $assoc_id, 'cate_id' => $cate_id));
        return " <input type='button' onclick=\"location.replace('{$url}');\" value='返回' />";
    }

    function insert($data) {
        $data['put_time'] = time();
        unset($data['id']);
        $sql = "select * from " . $this->tab . " where id=-1";
        $rs = $this->db->Execute($sql);
        $sql = $this->db->GetInsertSQL($rs, $data);
        return $this->db->Execute($sql);
    }

    function showForm($data, $eMsg=null) {
        $pvar['title'] = '上传图片';
        $pvar['form_act'] = Core::getUrl();
        $pvar['item'] = $data;
        $pvar['emsg'] = $eMsg;
        $pvar['goback'] = Core::getUrl('showlist');
        $pvar['assoc_id'] = $assoc_id;
        $pvar['cate_id'] = $cate_id;
        $pvar['btn'] = $this->btnShowlist($data['assoc_id'], $data['cate_id']);

        $this->addTplFile('form');
        $this->assign($pvar);
        $this->display();
    }

}

?>