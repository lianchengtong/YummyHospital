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

    public static function delete($key)
    {
        return self::getInstance()->delete($key);
    }

    public static function exist($key)
    {
        return self::getInstance()->exist($key);
    }

    public static function flush()
    {
        return self::getInstance()->flush();
    }

    public static function dataProvider($key, callable $callable)
    {
        $data = self::get($key);
        if (!$data) {
            if ($data = $callable()) {
                self::set($key, $data);
            }
        }

        return $data;
    }
}