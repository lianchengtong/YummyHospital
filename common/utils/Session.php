<?php

namespace common\utils;


class Session
{
    /**
     * @return \yii\web\Session
     */
    public static function instance()
    {
        return \Yii::$app->getSession();
    }

    public static function remove($key)
    {
        return self::instance()->remove($key);
    }

    public static function removeAll()
    {
        return self::instance()->removeAll();
    }

    public static function get($key, $default = null)
    {
        return self::instance()->get($key, $default);
    }

    public static function set($key, $value)
    {
        return self::instance()->set($key, $value);
    }

    public static function setFlash($key, $value = true, $removeAfterAccess = true)
    {
        self::instance()->setFlash($key, $value, $removeAfterAccess);
    }

    public static function getFlash($key, $default)
    {
        return self::instance()->getFlash($key, $default);
    }

    public static function getAllFlash($delete = false)
    {
        return self::instance()->getAllFlashes($delete);
    }
}