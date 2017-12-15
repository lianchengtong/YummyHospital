<?php

namespace common\utils;

use common\models\WebsiteConfig;
use League\Flysystem\Filesystem;
use Xxtime\Flysystem\Aliyun\OssAdapter;

/**
 * 唯一的 manager 类
 */
class AliyunOSS
{
    /**
     * @var Filesystem
     */
    private static $_instance;

    public static function instance()
    {
        if (!is_null(self::$_instance)) {
            return self::$_instance;
        }

        $configData = WebsiteConfig::getMultiValue([
            "site.aliyun.access_key_id",
            "site.aliyun.access_key_secret",
            'storage.aliyun_oss.domain',
            'storage.aliyun_oss.region',
            'storage.aliyun_oss.network',
            'storage.aliyun_oss.is_internal',
            'storage.aliyun_oss.bucket',
        ]);

        $adapterConfig   = [
            'access_id'     => $configData['site.aliyun.access_key_id'],
            'access_secret' => $configData['site.aliyun.access_key_secret'],
            'bucket'        => $configData['storage.aliyun_oss.bucket'],
            'endpoint'      => $configData['storage.aliyun_oss.region'] . ".aliyuncs.com",
        ];
        self::$_instance = new Filesystem(new OssAdapter($adapterConfig));
        return self::$_instance;
    }
}
