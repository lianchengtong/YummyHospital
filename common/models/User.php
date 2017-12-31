<?php

namespace common\models;

use common\base\ActiveRecord;
use common\models\interfaces\InterfaceUserAuth;
use common\utils\UserSession;
use Yii;
use yii\base\InvalidParamException;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string  $nickname
 * @property string  $head_image
 * @property string  $password_hash
 * @property string  $password_reset_token
 * @property string  $email
 * @property string  $phone
 * @property string  $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string  $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE   = 0;
    const STATUS_VERIFIED = 1;
    const STATUS_DISABLED = 99;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status'               => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire    = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    public static function randomPassword()
    {
        $random = Yii::$app->security->generateRandomKey();

        return Yii::$app->security->generatePasswordHash($random);
    }

    public static function getByEmail($email)
    {
        return self::find()->where(['email' => $email])->one();
    }

    /**
     * @param $type
     *
     * @return \common\models\interfaces\InterfaceUserAuth|ActiveRecord
     */
    public function getAuthAccount($type)
    {
        switch ($type) {
            case AuthWechat::AUTH_TYPE:
                $class = AuthWechat::className();
                break;
            default:
                throw new InvalidParamException($type . " : is not defined!");
        }

        return call_user_func_array([$class, "getByUserID"], [UserSession::getId()]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nickname', 'head_image', 'phone', 'auth_key', 'password_reset_token', 'password_hash'], 'string'],
            ['email', 'email'],
            [['email', 'phone'], 'default', 'value' => ''],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DISABLED]],
        ];
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function registerUser($userInfo)
    {
        $this->setAttributes($userInfo);
        $this->generateAuthKey();

        return $this->save();
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @param \common\models\interfaces\InterfaceUserAuth $userAuth
     *
     * @return bool|array
     */
    public function setUserAuth(InterfaceUserAuth $userAuth)
    {
        if (!$userAuth->connectWithUser($this)) {
            return $userAuth->getErrors();
        }

        return true;
    }
}
