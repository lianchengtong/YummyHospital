<?php

namespace common\utils;


class Cache
{
    public static function get($key)
    {
        return self::getInstance()->get($key);
    }

    /**
     * @return \yii\caching\CacheInterface
     */
    private static function getInstance()
    {
        return \Yii::$app->getCache();
    }

    public static function set($key, $value, $duration = null, $dependency = null)
    {
        return self::getInstance()->set($key, $value, $duration, $dependency);
    }
}