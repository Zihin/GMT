<?php
/***************************************************************
 * 前台入口文件
 ***************************************************************/
//define('sys_time_start', array_sum(explode(' ', microtime())));

include_once 'app/etc/front.config.php';
include_once LIB_DIR.'/errorhandler.php';
include_once LIB_DIR.'/core.php';
include_once LIB_DIR.'/global.php';

$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
mylog('upop',json_encode(_REQUEST));
//$file_name = __DIR__.'/test0.txt';
//file_put_contents($file_name,print_r($GLOBALS,true));
$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

//$str = '{"code":"wxpay","appid":"wx81b12ea3daceaf59","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1311354601","nonce_str":"8zlyiwnjkycsfdvqe1i0bxzobzmuegsn","openid":"o1Nc2wwLUqZuE6OQe5cWh-4dGSbE","out_trade_no":"GMT201603085555","result_code":"SUCCESS","return_code":"SUCCESS","sign":"17DBAEE5BDEB895269CC5FC3FD90FAE3","time_end":"20160308213507","total_fee":"1","trade_type":"NATIVE","transaction_id":"1005320965201603083831831018"}';
//$array_data = json_decode($str, true);
//vardump($array_data);
//exit;
if($array_data['code']=="wxpay"){
    $_REQUEST['code'] = "wxpay";
}


/* 支付方式代码 */
$pay_code = !empty($_REQUEST['code']) ? trim($_REQUEST['code']) : '';
$plugin_file = LIB_DIR.'/payment/'.$pay_code.'.php';

//file_put_contents("result.txt",$plugin_file);

/* 检查插件文件是否存在，如果存在则验证支付是否成功，否则则返回失败信息 */
if (file_exists($plugin_file))
{
    /* 根据支付方式代码创建支付类的对象并调用其响应操作方法 */
    include_once($plugin_file);

    $payment = new $pay_code();
    $test_no = 0;
    if($pay_code=="wxpay"){
        $test_no  = $payment->respond($array_data);
    }else{
        $test_no = $payment->respond();
    }
    if($test_no){
        header("Location:index.php?member,singup3,test_no,".$test_no);
    }
}

?>