<?php

use yii\db\Migration;

class m171212_093335_init_webconfig_data extends Migration
{
    private $_table_config = '{{%website_config}}';
    private $_table_group  = '{{%website_config_group}}';

    public function safeUp()
    {
        $this->batchInsert($this->_table_group, ['name', 'order', 'created_at'], [
            ["网站配置", 0, time()],
            ["邮件配置", 1, time()],
            ["缓存配置", 2, time()],
            ["文件存储", 3, time()],
            ["微信公众号", 4, time()],
            ["支付管理", 5, time()],
        ]);

        $emailMode = [
            'smtp'      => "SMTP 模式",
            'aliyun'    => "阿里云",
            'sendcloud' => "SendCloud",
        ];

        $cacheMode = [
            'file'     => "文件缓存",
            'redis'    => 'Redis',
            'memcache' => 'Memcache',
        ];

        $storageMode = [
            'file'       => '本地存储',
            'aliyun_oss' => '阿里云OSS',
        ];
        $payment     = [
            'alipay'    => '支付宝',
            'wechatpay' => '微信支付',
        ];

        $aliyunOSSRegions = [
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
        ];

        $this->batchInsert($this->_table_config, ['group_id', 'key', 'name', 'value', 'type', 'order', 'const_data', 'created_at'], [
            [1, 'site.domain', "网站访问地址", "http://", 'string', 0, "", time()],
            [1, 'site.name', "网站名称", "YummyHospital", 'string', 0, "", time()],
            [1, 'site.slogan', "网站副标题", "Beautiful & Easy!", 'string', 0, "", time()],
            [1, 'site.keyword', "网站关键字", "YummyHospital,医院CMS", 'string', 0, "", time()],
            [1, 'site.description', "网站描述", "一个好用的医院CMS管理系统", 'string', 0, "", time()],
            [1, 'site.regulator.icp', "ICP备案号", "", 'string', 0, "", time()],
            [1, 'site.regulator.police', "公安备案号", "", 'string', 0, "", time()],
            [1, 'site.statistic', "统计代码", "", 'text', 0, "", time()],
            [2, 'email.mode', "邮件发送模式", "smtp", 'single', 0, json_encode($emailMode), time()],
            [2, 'email.smtp.host', "SMTP 主机", "", 'string', 0, "", time()],
            [2, 'email.smtp.port', "SMTP 端口", "", 'string', 0, "", time()],
            [2, 'email.smtp.username', "SMTP 用户名", "", 'string', 0, "", time()],
            [2, 'email.smtp.password', "SMTP 密码", "", 'string', 0, "", time()],
            [2, 'email.smtp.timeout', "SMTP 超时", "", 'string', 0, "", time()],
            [3, 'cache.model', "缓存模式", "file", 'single', 0, json_encode($cacheMode), time()],
            [3, 'cache.file.path', "文件缓存路径", "@application/runtime/cache", 'string', 0, "", time()],
            [3, 'cache.redis.host', "Redis 主机地址", "", 'string', 0, "", time()],
            [3, 'cache.redis.port', "Redis 端口", "", 'string', 0, "", time()],
            [3, 'cache.redis.auth', "Redis 密码", "", 'string', 0, "", time()],
            [3, 'cache.memcache.host', "Memcache 主机地址", "", 'string', 0, "", time()],
            [3, 'cache.memcache.port', "Memcache 端口", "", 'string', 0, "", time()],
            [4, 'storage.mode', "文件存储模式", "file", 'single', 0, json_encode($storageMode), time()],
            [4, 'storage.file.path', "本地存储路径", "@application/web/upload", 'string', 0, "", time()],
            [4, 'storage.aliyun_oss.access_key_id', "阿里云OSS Access Key ID", "", 'string', 0, "", time()],
            [4, 'storage.aliyun_oss.access_key_token', "阿里云OSS Access Key Token", "", 'string', 0, "", time()],
            [4, 'storage.aliyun_oss.region', "阿里云OSS 区域", "", 'single', 0, json_encode($aliyunOSSRegions), time()],
            [4, 'storage.aliyun_oss.network', "阿里云OSS 网络类型", "classic", 'single', 0, json_encode(['classic' => '经典网络', 'vpc' => 'VPC']), time()],
            [4, 'storage.aliyun_oss.is_internal', "阿里云OSS 内网模式", "0", 'single', 0, json_encode(['是', '否']), time()],
            [4, 'storage.aliyun_oss.bucket', "阿里云OSS Bucket", "", 'string', 0, "", time()],
            [5, 'wechat.app_id', "AppID", "", 'string', 0, "", time()],
            [5, 'wechat.app_secret', "AppSecret", "", 'string', 0, "", time()],
            [6, 'payment.channel', "支付通道", "", 'multiple', 0, json_encode($payment), time()],
            [6, 'payment.alipay.token', "支付宝", "", 'string', 0, "", time()],
            [6, 'payment.wechatpay.token', "微信支付", "", 'string', 0, "", time()],
        ]);
    }

    public function safeDown()
    {
        $this->truncateTable($this->_table_config);
        $this->truncateTable($this->_table_group);
    }
}
