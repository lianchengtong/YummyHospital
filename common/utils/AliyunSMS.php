<?php

namespace common\utils;


use common\models\WebsiteConfig;
use Mrgoon\AliyunSmsSdk\Autoload;
use Mrgoon\AliyunSmsSdk\DefaultAcsClient;
use Mrgoon\AliyunSmsSdk\Profile\DefaultProfile;
use Mrgoon\Dysmsapi\Request\V20170525\SendSmsRequest;
use yii\base\Component;

class AliyunSMS extends Component
{
    public static function sendSms($to, $template_code, $data, $outId = '')
    {
        $configData      = WebsiteConfig::getMultiValue([
            "site.aliyun.access_key_id",
            "site.aliyun.access_key_secret",
        ]);
        $accessKeyId     = $configData['site.aliyun.access_key_id'];
        $accessKeySecret = $configData['site.aliyun.access_key_secret'];
        $signName        = "爱泡云";

        //短信API产品名
        $product = "Dysmsapi";
        //短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";
        //暂时不支持多Region
        $region = "cn-hangzhou";

        //初始化访问的acsCleint
        Autoload::config();

        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
        $acsClient = new DefaultAcsClient($profile);

        $request = new SendSmsRequest();
        //必填-短信接收号码
        $request->setPhoneNumbers($to);
        //必填-短信签名
        $request->setSignName($signName);
        //必填-短信模板Code
        $request->setTemplateCode($template_code);
        //选填-假如模板中存在变量需要替换则为必填(JSON格式)
        if ($data) {
            $request->setTemplateParam(json_encode($data));
        }

        //选填-发送短信流水号
        if ($outId) {
            $request->setOutId($outId);
        }

        //发起访问请求
        return $acsClient->getAcsResponse($request);
    }
}