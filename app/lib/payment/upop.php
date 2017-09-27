<?php

/**
 * ECSHOP 银联在线支付主文件
 ****唯一一条备注，使用者请尊重劳动成果，手下留情！****
	插件名称：银联在线支付(UPOP)插件 FOR ECSHOP
	插件版本：1.0
	插件作者：中国程项目组（成都之达科技有限公司）
	插件编码：GBK
	适用版本：ECSHOP 2.60及以上
	更新地址：http://www.cnvar.net/9025511.html
	支持站点：www.cnvar.net
	反馈地址：http://www.cnvar.net/9025511.html
	反馈邮箱/QQ账号：cnvar@qq.com
	
	目前仅支持中文版本，英文、繁体版本请自行调试
	有问题请及时反馈谢谢，可进群在线邀请群友进行帮助调试
	唯一官方QQ交流群：87010870
	
 */

/**
 * 类
 */
class UPOP
{
    /**
     * 生成支付代码
     * @param   array   $order  订单信息
     * @param   array   $this->payment    支付方式信息
     */

    static $api_url = array(
        0  => array(
            'front_pay_url' => 'http://58.246.226.99/UpopWeb/api/Pay.action',
            'back_pay_url'  => 'http://58.246.226.99/UpopWeb/api/BSPay.action',
            'query_url'     => 'http://58.246.226.99/UpopWeb/api/Query.action',
        ),
        1  => array(
            'front_pay_url' => 'http://www.epay.lxdns.com/UpopWeb/api/Pay.action',
            'back_pay_url'  => 'http://www.epay.lxdns.com/UpopWeb/api/BSPay.action',
            'query_url'     => 'http://www.epay.lxdns.com/UpopWeb/api/Query.action',
        ),
        2  => array(
            'front_pay_url' => 'https://unionpaysecure.com/api/Pay.action',
            'back_pay_url'  => 'https://besvr.unionpaysecure.com/api/BSPay.action',
            'query_url'     => 'https://query.unionpaysecure.com/api/Query.action',
        ),
    );
    private $payment =array(
        //'upop_account' =>'777290058125918',//商户代码，请改自己的测试商户号
        'upop_account' =>'802440048160678',//商户代码，请改自己的测试商户号
    );


    function get_code($order)
    {
        // 初始化变量
        //$upop_evn		= $this->payment['upop_evn'];		// 环境  2--生产环境
        $upop_evn = 2 ;
        header ( 'Content-type:text/html;charset=utf-8' );
        include_once 'upop/func/common.php';
        include_once 'upop/func/SDKConfig.php';
        include_once 'upop/func/secureUtil.php';
        include_once 'upop/func/log.class.php';
        $return_url = SITE_URL .'/respond.php?code=upop';
        /**
         * 消费交易-前台
         */


        /**
         *	以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考
         */
        // 初始化日志

        $log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );

        $log->LogInfo ( "============处理前台请求开始===============" );


        // 初始化日志
        $params = array(
            'version' => '5.0.0',				//版本号
            'encoding' => 'utf-8',				//编码方式
            'certId' => getSignCertId (),			//证书ID
            'txnType' => '01',				//交易类型
            'txnSubType' => '01',				//交易子类
            'bizType' => '000201',				//业务类型
            'frontUrl' =>  SITE_URL .'/index.php?member,singup3,test_no,'.$order['order_sn'],  		//前台通知地址
            'backUrl' => $return_url,		//后台通知地址
            'signMethod' => '01',		//签名方法
            'channelType' => '08',		//渠道类型，07-PC，08-手机
            'accessType' => '0',		//接入类型
            'merId' =>  $this->payment['upop_account'],		        //商户代码，请改自己的测试商户号
            'orderId' => $order['order_sn'],	//商户订单号
            'txnTime' => date('YmdHis'),	//订单发送时间
            'txnAmt' => $order['order_amount'] * 100,		//交易金额，单位分
            'currencyCode' => '156',	//交易币种
            'defaultPayType' => '0001',	//默认支付方式
            //'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
            'reqReserved' => $order['order_sn'], //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
        );


        // 签名
        sign ( $params );


        // 前台请求地址
        $front_uri = SDK_FRONT_TRANS_URL;
        $log->LogInfo ( "前台请求地址为>" . $front_uri );
        // 构造 自动提交的表单
        $html_form = create_html ( $params, $front_uri );

        $log->LogInfo ( "-------前台交易自动提交表单>--begin----" );
        $log->LogInfo ( $html_form );
        $log->LogInfo ( "-------前台交易自动提交表单>--end-------" );
        $log->LogInfo ( "============处理前台请求 结束===========" );
        return $html_form;
    }

    /**
     * 响应操作
     */
    function respond()
    {

        /**
         * Created by PhpStorm.
         * User: Administrator
         * Date: 2015/6/8
         * Time: 16:48
         */
        include_once 'upop/func/common.php';
        include_once 'upop/func/SDKConfig.php';
        include_once 'upop/func/secureUtil.php';
        include_once 'upop/func/log.class.php';

        if($_POST){
            $data=$_POST;
        }else {
            $data =file_get_contents('php://input');
            if(is_string($data)){
                $data = coverStringToArray ( $data );
            }
        }


        $str = implode('&&',$data);
        mylog('upop_respond',$str);
        $rs = verify($data);

        //验签成功
        if($data['respCode']=='00'){
            $pay_id = $data['orderId'];
            mylog('银联支付返回order_sn',$pay_id);

            // 检查商户账号是否一致。
            if ($this->payment['upop_account'] != $data['merId'])
            {
                return false;
            }
            $action_note = $data['respCode'] . ':'
                . $data['respMsg']
                . '银联交易号:'
                . $data['queryId'];
            mylog('银联交易日志',$action_note);
            // 完成订单。

            plugin('order_paid',$pay_id,$data['queryId']);
            //告诉用户交易完成
            return $pay_id;
        }else{
            return false;
        }

    }


    /**
     * 格式订单号
     */
    function _formatSN($sn)
    {
        return str_repeat('0', 9 - strlen($sn)) . $sn;
    }



    /**
     * 银联在线退货功能
     *
     * @param array $order   订单数据   $data['money_paid'] --订单在线支付总金额，单位元
     * @param array $refund  退款单数据
     * @return bool true--成功  false--失败
     */
    public function refund($order,$refund)
    {
        $this->payment = payment_info($order['pay_id']);
        $this->payment = get_payment($this->payment['pay_code']);

        /**
         *	退货
         */
        //$upop_evn		= $this->payment['upop_evn'];		// 环境  2--生产环境
        $upop_evn = 2 ;
        header ( 'Content-type:text/html;charset=utf-8' );
        include_once 'upop/func/common.php';
        include_once 'upop/func/SDKConfig.php';
        include_once 'upop/func/secureUtil.php';
        include_once 'upop/func/httpClient.php';
        include_once 'upop/func/log.class.php';

        /**
         *	以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考
         */

// 初始化日志
        $log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
        $log->LogInfo ( "===========处理后台请求开始============" );

        //计算手续费
        $rs_fee = 0;
        $poundage = $refund['amount'] * $rs_fee;
        $refund['amount'] = $refund['amount'] - $poundage;

        $params = array(
            'version' => '5.0.0',		//版本号
            'encoding' => 'utf-8',		//编码方式
            'certId' => getSignCertId (),	//证书ID
            'signMethod' => '01',		//签名方法
            'txnType' => '04',		//交易类型
            'txnSubType' => '00',		//交易子类
            'bizType' => '000201',		//业务类型
            'accessType' => '0',		//接入类型
            'channelType' => '07',		//渠道类型
            'merId' =>  $this->payment['upop_account'],		        //商户代码，请改自己的测试商户号
            'orderId' => $order['order_sn'] . '' . $this->_formatSN(rand(1,100000)),	//商户订单号
            'txnTime' => date('YmdHis'),	//订单发送时间
            'txnAmt' => $refund['amount'] * 100,		//交易金额，单位分
            'reqReserved' => $order['order_sn'], //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
            'origQryId' => $order['origQid'],    //原消费的queryId，可以从查询接口或者通知接口中获取
            'backUrl' => refund_url(basename(__FILE__, '.php')),		//后台通知地址
            'reqReserved' =>$order['order_sn'], //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
        );


        try{

            // 签名
            sign ( $params );

            //echo "请求：" . getRequestParamString ( $params );
            //$log->LogInfo ( "后台请求地址为>" . SDK_BACK_TRANS_URL );
            // 发送信息到后台
            $result = sendHttpRequest ( $params, SDK_BACK_TRANS_URL );
            //$log->LogInfo ( "后台返回结果为>" . $result );

            //echo "应答：" . $result;

            //返回结果展示
            $result_arr = coverStringToArray ( $result );
            if($result_arr['respCode']=='00'){
                //验签成功，进行处理


                op_refund_by_order_sn($order['order_sn'], $refund['amount']);
                header("Location: /manage/refund.php?act=refund&order_id=".$order['order_id']);
                return true;

            }else{
                //验签失败
                header("Location: /manage/refund.php?act=refund&order_id=".$order['order_id']);
                return false;
            }
        }catch (Exception $err){
            header("Location: /manage/refund.php?act=refund&order_id=".$order['order_id']);
        }
        exit;
    }


    /**
     * 银联在线退货后台通知
     * @param array $config   在线支付配置数据
     * @param array $order   订单数据
     * @param array $refund_transfer   退款转帐申请数据
     */
    public function refund_notify(){

        $this->payment        = get_payment('upop');

        /**
         * Created by PhpStorm.
         * User: Administrator
         * Date: 2015/6/8
         * Time: 16:48
         */
        include_once 'upop/func/common.php';
        include_once 'upop/func/SDKConfig.php';
        include_once 'upop/func/secureUtil.php';
        include_once 'upop/func/log.class.php';


        if (isset ( $_POST ['signature'] )) {
            echo verify ( $_POST ) ? '验签成功' : '验签失败';
            $orderId = $_POST ['orderId']; //其他字段也可用类似方式获取
            if($_POST['respCode']=='00') {
                //业务数据处理
                op_refund_by_order_sn(substr($_POST['orderId'],0,13), $_POST['txnAmt']/100);
            }

        } else {
            echo '签名为空';
        }
        exit;
    }

}
?>
