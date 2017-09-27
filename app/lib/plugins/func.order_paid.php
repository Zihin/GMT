<?php
/***************************************************************
 * 插件式函数定义文件
 *
 * @author yeahoo2000@163.com
 ***************************************************************/

/**
 * 从数据读取资讯列表
 * @param int $test_no 考生编号
 * @param int $trade_no 第三方平台交易号
 */
function func_order_paid($test_no,$trade_no=''){
    $db = Core::getDb();
    //$db->debug = true;
    $data['is_pay'] = 1;
    $data['trade_no'] = $trade_no;
    $sql = "select * from ".TB_PREFIX."candidate_test where test_no='".$test_no."'";
    $rs = $db->Execute($sql);
    $sql = $db->GetUpdateSQL($rs,$data);
    $rs = $db->Execute($sql);
    if($rs){
        $sql = "select * from ".TB_PREFIX."candidate_test where test_no='".$test_no."'";
        $testdata = $db->GetRow($sql);
        $sql = "select * from ".TB_PREFIX."member where id='".$testdata['mid']."'";
        $minfo = $db->GetRow($sql);
        $company = plugin('getconfig');
        $m['points'] = $minfo['points'] + $company['points'];
        $sql = "select * from ".TB_PREFIX."member where id='".$testdata['mid']."'";
        $rs = $db->Execute($sql);
        $sql = $db->GetUpdateSQL($rs,$m);
        $db->Execute($sql);

        return true;
    }

}
?>