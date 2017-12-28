<?php

namespace common\utils\pay;


use common\models\WebsiteConfig;
use common\utils\Request;
use Omnipay\Omnipay;

class Wechat implements InterfacePayment
{
    const WECHATPAY_COMMON = "WechatPay";
    const WECHATPAY_APP    = "WechatPay_App";
    const WECHATPAY_NATIVE = "WechatPay_Native";
    const WECHATPAY_JS     = "WechatPay_Js";
    const WECHATPAY_POS    = "WechatPay_Pos";
    const WECHATPAY_MWEB   = "WechatPay_Mweb";

    /** @var \Omnipay\WechatPay\Gateway $gateway */
    private static $gateway;

    public static function callbackOkString()
    {
        $return = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';

        return $return;
    }

    public static function processCallback()
    {
        $callbackData = file_get_contents('php://input');

        $response = self::instance()->completePurchase([
            'request_params' => $callbackData,
        ])->send();

        if ($response->isPaid()) {
            $responseData = $response->getRequestData();
            return $responseData;
        }
        return false;
    }

    public static function instance($type = self::WECHATPAY_COMMON)
    {
        if (!is_null(self::$gateway[$type])) {
            return self::$gateway[$type];
        }
        $keys   = [
            "payment.wechatpay.app_id",
            "payment.wechatpay.app_secret",
            "payment.wechatpay.mch_id",
            "payment.wechatpay.key",
            "payment.wechatpay.cert",
            "payment.wechatpay.callback",
            "payment.wechatpay.api_key",
        ];
        $config = WebsiteConfig::getMultiValue($keys);

        //gateways: WechatPay_App, WechatPay_Native, WechatPay_Js, WechatPay_Pos, WechatPay_Mweb

        /** @var \Omnipay\WechatPay\Gateway $gateway */
        $gateway = Omnipay::create($type);
        $gateway->setAppId($config['payment.wechatpay.app_id']);
        $gateway->setMchId($config['payment.wechatpay.mch_id']);
        $gateway->setApiKey($config["payment.wechatpay.api_key"]);
        $gateway->setNotifyUrl($config['payment.wechatpay.callback']);
        $gateway->setKeyPath(\Yii::getAlias($config['payment.wechatpay.key']));
        $gateway->setCertPath(\Yii::getAlias($config['payment.wechatpay.cert']));

        return self::$gateway[$type] = $gateway;
    }

    public static function createJSOrder($openID, $title, $orderID, $price)
    {
        $order = [
            'body'             => $title,
            'detail'           => "无",
            'open_id'          => $openID,
            'out_trade_no'     => $orderID,
            'total_fee'        => $price, //=0.01
            'spbill_create_ip' => Request::ip(),
            'fee_type'         => 'CNY',
        ];

        /**
         * @var \Omnipay\WechatPay\Message\CreateOrderRequest  $request
         * @var \Omnipay\WechatPay\Message\CreateOrderResponse $response
         */
        $response = self::instance(self::WECHATPAY_JS)->purchase($order)->send();
        if (!$response->isSuccessful()) {
            return false;
        }

        return $response->getJsOrderData();
    }
}