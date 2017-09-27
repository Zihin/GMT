<?php
//电脑微信支付类
class wxpay
{
	public $wxpay_app_id		= '';
	public $wxpay_app_secret	= '';
	public $wxpay_partnerid	= '';
	public $wxpay_partnerkey	= '';

	//证书路径,注意应该填写绝对路径
	private $SSLCERT_PATH = "";
	private $SSLKEY_PATH = "";

	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
//	const NOTIFY_URL = 'http://kshop.toms.mobi/mobile/demo1/demo/notify_url.php';

	//const NOTIFY_URL = SITE_URL.'/index.php?member,respond,paymethod,wxpay';
	const NOTIFY_URL = 'http://www.gmtest.org.cn/respond.php?member,respond,paymethod,wxpay&code=wxpay';

	/**
	 * 构造函数
	 *
	 * @access  public
	 * @param
	 *
	 * @return void
	 */


	function __construct()
	{
		// print_r($payment);die;
		$this->wxpay_app_id		=       'wx81b12ea3daceaf59';
		$this->wxpay_app_secret	=       'fd247c74935b641c2835e7bed2c52ce2';
		$this->wxpay_partnerid	=       '1311354601';
		$this->wxpay_partnerkey	=       'ouXHoLWylomJdOSV3JL4Zbdd7DTYl1wO';
		$this->SSLCERT_PATH =  LIB_DIR.'\payment\wxpay\cacert\apiclient_cert.pem';
		$this->SSLKEY_PATH =  LIB_DIR.'\payment\wxpay\cacert\apiclient_key.pem';
	}

	/**
	 * 生成支付代码
	 * @param   array   $order      订单信息
	 * @param   array   $payment    支付方式信息
	 */
	function get_code($order)
	{
		include_once (LIB_DIR.'/payment/wxpay/WxPayPubHelper.php');
		$charset = 'utf-8';

		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub();

		//设置统一支付接口参数
		//设置必填参数
		//appid已填,商户无需重复填写
		//mch_id已填,商户无需重复填写
		//noncestr已填,商户无需重复填写
		//spbill_create_ip已填,商户无需重复填写
		//sign已填,商户无需重复填写
		$unifiedOrder->setParameter("body",$order['weixin_goods']);//商品描述
		//自定义订单号，此处仅作举例
		$timeStamp = time();
		$out_trade_no = $order['order_sn'];
		$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号
		$unifiedOrder->setParameter("total_fee",intval($order['order_amount'] * 100));//总金额
		//$unifiedOrder->setParameter("notify_url",return_url(basename(__FILE__, '.php')));//通知地址
		$unifiedOrder->setParameter("notify_url",SITE_URL .'/respond.php?code=wxpay');//通知地址  return_url(basename(__FILE__, '.php'))

		$unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
		//非必填参数，商户可根据实际情况选填
		//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
		//$unifiedOrder->setParameter("device_info","XXXX");//设备号
		//$unifiedOrder->setParameter("attach","XXXX");//附加数据
		//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
		//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
		//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
		//$unifiedOrder->setParameter("openid","XXXX");//用户标识
		//$unifiedOrder->setParameter("product_id","XXXX");//商品ID

		//获取统一支付接口结果
		$unifiedOrderResult = $unifiedOrder->getResult();

		//商户根据实际情况设置相应的处理流程
		if ($unifiedOrderResult["return_code"] == "FAIL")
		{
			//商户自行增加处理流程
			//echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
		}
		elseif($unifiedOrderResult["result_code"] == "FAIL")
		{
			//商户自行增加处理流程
			//echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
			//echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
		}
		elseif($unifiedOrderResult["code_url"] != NULL)
		{
			//从统一支付接口获取到code_url
			$code_url = $unifiedOrderResult["code_url"];
			//商户自行增加处理流程
			//......
		}
		$button = '<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Language" content="zh-cn">
<title>GMT充值跳转</title>
<link href="../../css/wechat_pay.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
    <h1 class="mod-title">
        <span class="ico-wechat"></span><span class="text">微信支付</span>
    </h1>
    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount">￥'.$order['order_amount'].'</div>
        <div id="qrcode" class="qr-image">
            <!--二维码图片-->
    	</div>
        <!--detail-open 加上这个类是展示订单信息，不加不展示-->
        <div class="detail detail-open" id="orderDetail" style="">
            <dl class="detail-ct" style="display: block;">
                <dt>商家</dt>
                <dd id="storeName">GMT</dd>
                <dt>商品名称</dt>
                <dd id="productName">'.$order['weixin_goods'].'</dd>
                <dt>交易单号</dt>
                <dd id="billId">'.$out_trade_no.'</dd>
                <dt>创建时间</dt>
                <dd id="createTime">'.date('Y-m-d H:i:s').'</dd>
            </dl>
        </div>
        <div class="tip">
            <span class="dec dec-left"></span>
            <span class="dec dec-right"></span>
            <div class="ico-scan"></div>
            <div class="tip-text">
                <p>请使用微信扫一扫支付</p>
                <p>完成支付后关闭此页面</p>
            </div>
        </div>
     </div>

    <div class="foot">
        <div class="inner">
            <p>您若对上述交易有疑问</p>
            <p>请联系我们的客服 <a href="javascript:void(0);" class="link"></a></p>
        </div>
    </div>
	<script src="../../js/qrcode.js"></script>
	<script src="../../js/jquery-1.7.2.min.js"></script>
	<script>
		window.onload = function(){
			var url = \''.$code_url.'\';
			var qr = qrcode(10, \'M\');
			qr.addData(url);
			qr.make();
			var code=document.createElement(\'DIV\');
			code.innerHTML = qr.createImgTag();
			var element=document.getElementById("qrcode");
			element.appendChild(code);
			var timer = setInterval(function(){
				$.get("index.php?member,checkpay,test_id,'.$order['order_id'].'",function(data){
					var data = JSON.parse(data);
					if(data.status){
						clearInterval(timer);
						$("#notify_button").removeClass("pay_botton");
						$("#notify_button").addClass("pay_success_botton");
						setTimeout("CloseWebPage()",3000);
						window.location.href="http://"+window.location.host;
					}
				});
			},5000);
		};

		function CloseWebPage(){
		 if (navigator.userAgent.indexOf("MSIE") > 0) {
		  if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
		   window.opener = null;
		   window.close();
		  } else {
		   window.open("", "_top");
		   window.top.close();
		  }
		 }
		 else if (navigator.userAgent.indexOf("Firefox") > 0) {
		  window.location.href = "about:blank ";
		 } else {
		  window.opener = null;
		  window.open("", "_self", "");
		  window.close();
		 }
		}
	</script>
</body>
</html>';
		if(!file_exists(ROOT."/data/wxhtml")){
			@make_dir(ROOT."/data/wxhtml",0777);
		}

		$wxpage = "wx".$order['order_sn'].".html";
		$filename = ROOT."/data/wxhtml/".$wxpage;
		@file_put_contents($filename, $button);
		$button = '<input type="button" class="redbtn" onClick="window.open(\''.SITE_URL.'/data/wxhtml/'.$wxpage.'\');" value="立即支付"/>';
// echo $button;die;
		return $button;
	}


	/**
	 * 响应操作
	 */
	function respond($array_data)
	{


		/*取返回参数*/
		$fields = 'bank_billno,bank_type,discount,fee_type,input_charset,notify_id,out_trade_no,partner,product_fee'
			.',sign_type,time_end,total_fee,trade_mode,trade_state,transaction_id,transport_fee,result_code,return_code';
		$arr = null;
		foreach(explode(',',$fields) as $val){
			if(isset($array_data[$val])){
				$arr[$val] = trim($array_data[$val]);
			}
		}
		$str = implode('&&',$arr);
		mylog('wxpay',$str);
		$order_sn   = $arr['out_trade_no'];
		//$order_sn = 'GMT201603063108';

		/* 如果trade_state大于0则表示支付失败 */
		if ($arr['result_code'] != "SUCCESS" || $arr['return_code'] != "SUCCESS")
		{
			return false;
		}

		/* 检查支付的金额是否相符 */
//		if (!check_money($log_id, $arr['total_fee'] / 100))
//		{
//			return false;
//		}

		/* 改变订单状态 */
		plugin('order_paid',$order_sn,$arr['transaction_id']);

		if(file_exists(ROOT."/data/wxhtml/wx".$order_sn."html")){
			@unlink(ROOT."/data/wxhtml/wx".$order_sn."html");
		}
		return $order_sn;
	}



	/**
	 * 微信支付在线退款后台通知，无通知
	 * @param array $config   在线支付配置数据
	 * @param array $order   订单数据
	 * @param array $refund_transfer   退款转帐申请数据
	 */
	public function refund_notify()
	{

		return true;
	}



	/**
	 * 创建sign
	 * @return string
	 */
	public function create_sign( $arr ){
		$para = $this->parafilter($arr);
		$para = $this->argsort($para);
		$signValue = $this->createlinkstring($para);
		$signValue = $signValue."&key=".$this->partnerKey;
		$signValue = strtoupper(md5($signValue));
		return $signValue;
	}

	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	public function createlinkstring($para) {
		$arg  = "";
		foreach ($para as $key => $val ) {
			$arg.=strtolower($key)."=".$val."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);

		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

		return $arg;

	}

	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */

	public	function parafilter($para) {
		$para_filter = array();
		foreach ($para as $key => $val ) {
			if($key == "sign_method" || $key == "sign" ||$val == "")continue;
			else	$para_filter[$key] = $para[$key];
		}
		return $para_filter;
	}

	/**
	 * 对数组排序
	 * @param $para 排序前的数组
	 * return 排序后的数组
	 */
	public function argsort($para) {
		ksort($para);
		reset($para);
		return $para;
	}

	/**
	 * 从xml中获取数组
	 * @return array
	 */
	public function getXmlArray() {
		$postStr = @file_get_contents('php://input');
		if ($postStr) {
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			if (! is_object($postObj)) {
				return false;
			}
			$array = json_decode(json_encode($postObj), true); // xml对象转数组
			return array_change_key_case($array, CASE_LOWER); // 所有键小写
		} else {
			return false;
		}
	}
}