<?php
/***************************************************************
 * 支付回调
 ***************************************************************/
class Respond extends Action{
    var $AuthLevel = ACT_OPEN;
    function process(){
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

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
            if($pay_code=="wxpay"){
                $msg  = ($payment->respond($array_data)) ? 1 : 0;
            }else{
                $msg = ($payment->respond()) ? 1 : 0;
            }
        }
        $pvar['self_id'] = 'singup';
        $this->addTplFile('singup3');
        $this->assign(stripQuotes($pvar));
        $this->display();
    }
}
?>