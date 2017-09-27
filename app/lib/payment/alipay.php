<?php

/**
 *  支付宝插件
 * 
 * 20014-10-22 K+系列，并保留所有权利。
*/

/**
 * 类
 */
class alipay
{

	/**
	 * 构造函数
	 *
	 * @access  public
	 * @param
	 *
	 * @return void
	 */
	function alipay()
	{
		$this->respond_url = SITE_URL .'/respond.php?code=alipay';

		$this->payment = array(
			'alipay_account' => '28055214@qq.com',
			'alipay_partner' => '2088811416021374',
			'alipay_key' => '1gdv7rviyjrdd58vnz8r752au88cjtqh',
		);
	}

	function __construct()
	{
		$this->alipay();
	}

	/**
	 * 生成支付代码
	 * @param   array   $order      订单信息
	 * @param   array   $this->payment    支付方式信息
	 */
	function get_code($order)
	{
		$charset = 'utf-8';
		$real_method = 2;

		switch ($real_method){
			case '0':
				$service = 'trade_create_by_buyer';
				break;
			case '1':
				$service = 'create_partner_trade_by_buyer';
				break;
			case '2':
				$service = 'create_direct_pay_by_user';
				break;
		}

		$extend_param = 'isv^sh22';


		$parameter = array(

			'extend_param'      => $extend_param,
			'service'           => $service,
			'partner'           => $this->payment['alipay_partner'],
			//'partner'           => ALIPAY_ID,
			'_input_charset'    => $charset,
			'notify_url'        => $this->respond_url,
			'return_url'        => $this->respond_url,
			/* 业务参数 */
			'subject'           => "{$order['weixin_goods']}",
			'out_trade_no'      => $order['order_sn'],
			'price'             => $order['order_amount'],
			'quantity'          => 1,
			'payment_type'      => 1,
			/* 物流参数 */
			'logistics_type'    => 'EXPRESS',
			'logistics_fee'     => 0,
			'logistics_payment' => 'BUYER_PAY_AFTER_RECEIVE',
			/* 买卖双方信息 */
			'seller_email'      => $this->payment['alipay_account'],

			'body'              => $order['order_sn']
		);
		ksort($parameter);
		reset($parameter);

		$param = '';
		$sign  = '';

		foreach ($parameter AS $key => $val)
		{
			$param .= "$key=" .urlencode($val). "&";
			$sign  .= "$key=$val&";
		}

		$param = substr($param, 0, -1);
		$sign  = substr($sign, 0, -1). $this->payment['alipay_key'];
		//$sign  = substr($sign, 0, -1). ALIPAY_AUTH;

		$button = '<input type="button" value="立即支付" class="redbtn" onclick="window.open(\'https://mapi.alipay.com/gateway.do?'.$param. '&sign='.md5($sign).'&sign_type=MD5\')" value="' .$GLOBALS['_LANG']['pay_button']. '" />';

		return $button;
	}

	/**
	 * 响应操作
	 */
	function respond()
	{

		if (!empty($_POST))
		{
			foreach($_POST as $key => $data)
			{
				$_GET[$key] = $data;
			}
		}

		$body = $_GET['body'];

		$seller_email = rawurldecode($_GET['seller_email']);
		$order_sn = trim($_GET['out_trade_no']);
		$str = implode('&&',$_GET);
		mylog('alipay_respond',$str);
		// $order_sn = str_replace($_GET['subject'], '', $_GET['out_trade_no']);
		/* 检查数字签名是否正确 */
		ksort($_GET);
		reset($_GET);

		$sign = '';
		foreach ($_GET AS $key=>$val)
		{
			if ($key != 'sign' && $key != 'sign_type' && $key != 'code')
			{
				$sign .= "$key=$val&";
			}
		}


		$sign = substr($sign, 0, -1) . $this->payment['alipay_key'];
		//$sign = substr($sign, 0, -1) . ALIPAY_AUTH;

		if (md5($sign) != $_GET['sign'])
		{
			return false;
		}

		/* 检查支付的金额是否相符 */
//		if (!check_money($order_sn, $_GET['total_fee']))
//		{
//			return false;
//		}

		if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS')
		{
			/* 改变订单状态 */
			plugin('order_paid',$order_sn,$_GET['trade_no']);

			return $order_sn;
		}
		elseif ($_GET['trade_status'] == 'TRADE_FINISHED')
		{
			/* 改变订单状态 */
			plugin('order_paid',$order_sn,$_GET['trade_no']);

			return $order_sn;
		}
		elseif ($_GET['trade_status'] == 'TRADE_SUCCESS')
		{
			/* 改变订单状态 */
			plugin('order_paid',$order_sn,$_GET['trade_no']);

			return $order_sn;
		}
		else
		{
			return false;
		}
	}
}
?>