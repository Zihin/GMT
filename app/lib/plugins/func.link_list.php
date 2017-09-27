<?php
/***************************************************************
 * ���ʽ���������ļ�
 *
 * @author AlingXiao
 ***************************************************************/

/**
 * �����ݶ�ȡ���������б�
 * @param int $module ��ʾģ��
 * @param int $num ��ȡ����
 * @param int|string cate ���ID�Ż�ID��
 */
function func_link_list($num, $not = null){
    include_once LIB_DIR.'/common/category.php';
    $db = Core::getDb();
    //$db->debug = true;
    $data = array();
    $sqlWhere = " where state=1";
    $sqlWhere .= $not?" and id not in($not)" : '';
    $sqlOrder = " order by sort asc ,id desc";
    $sql = "select * from ".TB_PREFIX."link";
    $rs = $db->SelectLimit($sql.$sqlWhere.$sqlOrder,$num,0);
    $list = array();
    while(!$rs->EOF){
        $rs->fields['put_time'] = date('Y-m-d',$rs->fields['put_time']);
        $rs->fields['short_title'] = utf8Cut(strip_tags($rs->fields['title']),4,'');
        $data['list'][] = $rs->fields;
        $rs->MoveNext();
    }
    return stripQuotes($data);
}
?>
