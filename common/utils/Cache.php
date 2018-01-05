<?php

namespace common\utils;


use yii\caching\ExpressionDependency;

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

    public static function getOrSet($key, callable $callable, $duration = null, $dependency = null)
    {
        if (YII_DEBUG && is_null($dependency)) {
            $dependency = new ExpressionDependency("1==0");
        }

        return self::getInstance()->getOrSet($key, $callable, $duration, $dependency);
    }

    public static function model($modalClassName, $id, callable $callable)
    {
        $key = "model." . $modalClassName . $id;

        return self::getOrSet($key, $callable);
    }
}