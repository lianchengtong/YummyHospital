<?php

namespace common\utils;


use common\models\ManageUser;
use common\models\User;
use yii\web\IdentityInterface;

class UserSession
{
    /**
     * @return \yii\web\User
     */
    private static function instance()
    {
        return \Yii::$app->getUser();
    }

    /**
     * @return null|\yii\web\IdentityInterface|User
     */
    public static function identity()
    {
        return self::instance()->getIdentity();
    }

    public static function nickname()
    {
        return self::identity()->nickname;
    }

    public static function getId()
    {
        return self::instance()->getId();
    }

    public static function isGuest()
    {
        return self::instance()->getIsGuest();
    }

    public static function logout()
    {
        return self::instance()->logout(true);
    }

    public static function login(IdentityInterface $user, $duration = 0)
    {
        return self::instance()->login($user, $duration);
    }


    public static function needLogin()
    {
        self::instance()->loginRequired();
    }

    public static function isAdmin()
    {
        return ManageUser::getUser(self::getId());
    }

    public static function getCoin()
    {
        return self::identity()->coin->coin;
    }
}