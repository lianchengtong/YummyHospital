<?php

namespace console\controllers;


use common\models\WebsiteConfig;
use common\models\WebsiteConfigGroup;
use console\base\BaseController;

class ConfigDataController extends BaseController
{
    public function actionUp()
    {
        $configData = $this->configs();

        $trans = \Yii::$app->getDb()->beginTransaction();
        try {
            foreach ($configData as $groupItem) {
                $model       = new WebsiteConfigGroup();
                $model->name = $groupItem['name'];
                if (!$model->save()) {
                    throw new \Exception(json_encode($model->getErrors(), JSON_UNESCAPED_UNICODE));
                }

                foreach ($groupItem['items'] as $configItem) {
                    echo sprintf("%s: %s\n", $model->name, $configItem['name']);
                    $configModel           = new WebsiteConfig();
                    $configModel->group_id = $model->primaryKey;
                    $configModel->setAttributes($configItem);
                    if (!$configModel->save()) {
                        throw new \Exception(json_encode($configModel->getErrors(), JSON_UNESCAPED_UNICODE));
                    }
                }
                echo "\n\n";
            }

            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollBack();
            throw new \Exception($e);
        }

        echo "DONE";
    }

    private function configs()
    {
        $data = [
            [
                'name'  => '网站',
                'items' => [
                    [
                        'key'   => 'site.logo',
                        'name'  => '网站名称',
                        'value' => '@web/images/logo.png',
                    ],
                    [
                        'key'   => 'site.domain',
                        'name'  => '网站访问地址',
                        'value' => 'http://',
                    ],
                    [
                        'key'  => 'site.name',
                        'name' => '网站名称',
                    ],
                    [
                        'key'   => 'site.slogan',
                        'name'  => '网站副标题',
                        'value' => 'Beautiful & Easy!',
                    ],
                    [
                        'key'   => 'site.keyword',
                        'name'  => '网站关键字',
                        'value' => 'YummyHospital,医院CMS',
                    ],
                    [
                        'key'   => 'site.description',
                        'name'  => '网站描述',
                        'value' => '一个好用的医院CMS管理系统',
                    ],
                    [
                        'key'  => 'site.regulator.icp',
                        'name' => 'ICP备案号',
                    ],
                    [
                        'key'  => 'site.regulator.police',
                        'name' => '公安备案号',
                    ],
                    [
                        'key'  => 'site.statistic.baidu',
                        'name' => '百度统计ID',
                        'hint' => '只写ID即可',
                    ],
                    [
                        'key'  => 'site.statistic.other',
                        'name' => '其它统计代码',
                        'type' => WebsiteConfig::TYPE_TEXT,
                        'hint' => 'JS代码，带Script标签',
                    ],
                ],
            ],
            [
                'name'  => '全局',
                'items' => [
                    [
                        'key'  => $this->splitKey(),
                        'type' => WebsiteConfig::TYPE_SPLIT,
                        'name' => "阿里云配置",
                    ],
                    [
                        'key'   => 'site.aliyun.access_key_id',
                        'name'  => 'Access Key ID',
                        'value' => defined('OSS_KEY_ID') ? OSS_KEY_ID : "",
                    ],
                    [
                        'key'   => 'site.aliyun.access_key_secret',
                        'name'  => 'Access Key Secret',
                        'value' => defined('OSS_KEY_SECRET') ? OSS_KEY_SECRET : "",
                    ],
                ],
            ],
            [
                'name'  => '邮件',
                'items' => [
                    [
                        'key'   => 'email.smtp.host',
                        'name'  => 'SMTP 主机',
                        'value' => 'smtpdm.aliyun.com',
                    ],
                    [
                        'key'   => 'email.smtp.port',
                        'name'  => 'SMTP 端口',
                        'value' => '80',
                    ],
                    [
                        'key'   => 'email.smtp.username',
                        'name'  => 'SMTP 用户名',
                        'value' => 'service@mail-service.ipaoyun.com',
                    ],
                    [
                        'key'   => 'email.smtp.password',
                        'name'  => 'SMTP 密码',
                        'value' => defined('ALIYUN_MAIL_SMTP_PASSWORD') ? ALIYUN_MAIL_SMTP_PASSWORD : "",
                    ],
                    [
                        'key'   => 'email.smtp.nickname',
                        'name'  => 'SMTP 发信人名称',
                        'value' => '爱泡云',
                    ],
                ],
            ],
            [
                'name'  => '缓存',
                'items' => [
                    [
                        'key'        => 'cache.model',
                        'name'       => "缓存模式",
                        'value'      => "file",
                        'type'       => WebsiteConfig::TYPE_SINGLE_SELECTION,
                        'const_data' => json_encode([
                            'file'     => "文件缓存",
                            'redis'    => 'Redis',
                            'memcache' => 'Memcache',
                        ]),
                    ],
                    [
                        'key'  => $this->splitKey(),
                        'type' => WebsiteConfig::TYPE_SPLIT,
                        'name' => "文件缓存配置",
                    ],
                    [
                        'key'   => 'cache.file.path',
                        'name'  => "缓存路径",
                        'value' => "@application/runtime/cache",
                    ],

                    [
                        'key'  => $this->splitKey(),
                        'type' => WebsiteConfig::TYPE_SPLIT,
                        'name' => "Redis配置",
                    ],
                    [
                        'key'  => 'cache.redis.host',
                        'name' => "主机地址",
                    ],
                    [
                        'key'  => 'cache.redis.port',
                        'name' => "端口",
                    ],
                    [
                        'key'  => 'cache.redis.auth',
                        'name' => "密码",
                    ],

                    [
                        'key'  => $this->splitKey(),
                        'type' => WebsiteConfig::TYPE_SPLIT,
                        'name' => "Memcache设置",
                    ],
                    [
                        'key'  => 'cache.memcache.host',
                        'name' => "主机地址",
                    ],
                    [
                        'key'  => 'cache.memcache.port',
                        'name' => "端口",
                    ],
                ],
            ],
            [
                'name'  => '存储',
                'items' => [
                    [
                        'key'        => 'storage.mode',
                        'name'       => "文件存储模式",
                        'value'      => "file",
                        'type'       => WebsiteConfig::TYPE_SINGLE_SELECTION,
                        'const_data' => json_encode([
                            'file'       => '本地存储',
                            'aliyun_oss' => '阿里云OSS',
                        ]),
                    ],
                    [
                        'key'  => $this->splitKey(),
                        'type' => WebsiteConfig::TYPE_SPLIT,
                        'name' => "本地存储配置",
                    ],
                    [
                        'key'   => 'storage.file.path',
                        'name'  => "本地存储路径",
                        'value' => "@web/upload",
                    ],

                    [
                        'key'  => $this->splitKey(),
                        'type' => WebsiteConfig::TYPE_SPLIT,
                        'name' => "阿里云OSS配置",
                    ],
                    [
                        'key'   => 'storage.aliyun_oss.domain',
                        'name'  => "访问域名",
                        'hint'  => "访问域名",
                        'value' => defined("OSS_DOMAIN") ? OSS_DOMAIN : "",
                    ],
                    [
                        'key'        => 'storage.aliyun_oss.region',
                        'name'       => "区域",
                        'value'      => 'oss-cn-hangzhou',
                        'type'       => WebsiteConfig::TYPE_SINGLE_SELECTION,
                        'const_data' => json_encode([
                            'oss-cn-hangzhou'    => '杭州',
                            'oss-cn-shanghai'    => '上海',
                            'oss-cn-qingdao'     => '青岛',
                            'oss-cn-beijing'     => '北京',
                            'oss-cn-zhangjiakou' => '张家口',
                            'oss-cn-shenzhen'    => '深圳',
                            'oss-cn-hongkong'    => '香港',
                            'oss-us-west-1'      => '硅谷',
                            'oss-us-east-1'      => '弗吉尼亚',
                            'oss-ap-southeast-1' => '新加坡',
                            'oss-ap-southeast-2' => '悉尼',
                            'oss-ap-northeast-1' => '日本',
                            'oss-eu-central-1'   => '法兰克福',
                            'oss-me-east-1'      => '迪拜',
                        ]),
                    ],
                    [
                        'key'        => 'storage.aliyun_oss.is_internal',
                        'name'       => "内网模式",
                        'value'      => '1',
                        'type'       => WebsiteConfig::TYPE_SINGLE_SELECTION,
                        'const_data' => json_encode(['否', '是']),
                    ],
                    [
                        'key'  => 'storage.aliyun_oss.bucket',
                        'name' => "Bucket",
                    ],
                ],
            ],
            [
                'name'  => '支付',
                'items' => [
                    [
                        'key'        => 'payment.channel',
                        'name'       => "支付通道",
                        'type'       => WebsiteConfig::TYPE_MULTIPLE_SELECTION,
                        'hint'       => '按Ctrl可进行多选',
                        'const_data' => json_encode([
                            'alipay'    => '支付宝',
                            'wechatpay' => '微信支付',
                        ]),
                    ],

                    [
                        'key'  => $this->splitKey(),
                        'type' => WebsiteConfig::TYPE_SPLIT,
                        'name' => "支付宝",
                    ],
                    [
                        'key'        => 'payment.alipay.sign_type',
                        'name'       => "加密类型",
                        'value'      => "RSA",
                        'type'       => WebsiteConfig::TYPE_SINGLE_SELECTION,
                        'const_data' => json_encode([
                            'RSA'  => 'RSA',
                            'RSA2' => 'RSA2',
                        ]),
                    ],
                    [
                        'key'   => 'payment.alipay.app_id',
                        'name'  => "AppID",
                        'value' => "",
                    ],
                    [
                        'key'   => 'payment.alipay.cert_private',
                        'name'  => "私钥",
                        'value' => "@application/certs/alipay/rsa_private_key_pkcs8.pem",
                    ],
                    [
                        'key'   => 'payment.alipay.cert_public',
                        'name'  => "公钥",
                        'value' => "@application/certs/alipay/alipay_public_key.pem",
                    ],
                    [
                        'key'   => 'payment.alipay.callback',
                        'name'  => "回调地址",
                        'value' => "http://xxx.com/callback",
                        'hint'  => "http://xxx.com/callback",
                    ],

                    [
                        'key'  => $this->splitKey(),
                        'type' => WebsiteConfig::TYPE_SPLIT,
                        'name' => "微信支付",
                    ],
                    [
                        'key'  => 'payment.wechatpay.app_id',
                        'name' => "AppID",
                        'hint' => "绑定支付的APPID（必须配置，开户邮件中可查看）",
                    ],
                    [
                        'key'  => 'payment.wechatpay.app_secret',
                        'name' => '公众号Secret',
                        'hint' => '必须配置，开户邮件中可查看',
                    ],
                    [
                        'key'  => 'payment.wechatpay.mch_id',
                        'name' => '商户号',
                        'hint' => '必须配置，开户邮件中可查看',
                    ],
                    [
                        'key'  => 'payment.wechatpay.key',
                        'name' => '支付密钥',
                        'hint' => '必须配置，登录商户平台自行设置',
                    ],
                    [
                        'key'  => 'payment.wechatpay.api_cert_pem',
                        'name' => '证书',
                        'hint' => '仅退款、撤销订单时需要，可登录商户平台下载',
                    ],
                    [
                        'key'  => 'payment.wechatpay.api_cert_pem_key',
                        'name' => '证书密钥',
                        'hint' => '仅退款、撤销订单时需要，可登录商户平台下载',
                    ],
                    [
                        'key'   => 'payment.wechatpay.callback',
                        'name'  => "回调地址",
                        'value' => "http://xxx.com/callback",
                        'hint'  => "异步回调通知 http://xxx.com/callback",
                    ],
                ],
            ],
            [
                'name'  => '公众号',
                'items' => [
                    [
                        'key'  => 'wechat.app_id',
                        'name' => 'AppID',
                    ],
                    [
                        'key'  => 'wechat.app_secret',
                        'name' => 'AppSecret',
                    ],
                    [
                        'key'  => 'wechat.token',
                        'name' => 'Token',
                    ],
                ],
            ],
        ];

        return $data;
    }

    private function splitKey()
    {
        return "split." . \Yii::$app->getSecurity()->generateRandomString();
    }

    public function actionDown()
    {
        $command = WebsiteConfig::getDb()->createCommand();
        $command->truncateTable(WebsiteConfig::tableName())->execute();
        $command->truncateTable(WebsiteConfigGroup::tableName())->execute();
    }
}
