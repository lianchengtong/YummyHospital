<?php

namespace common\models;


use common\base\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * @property integer             $id
 * @property integer             $user_id
 * @property string              $open_id
 * @property string              $access_token
 * @property string              $refresh_token
 * @property integer             $access_token_expire_at
 * @property integer             $refresh_token_expire_at
 * @property integer             $created_at
 * @property \common\models\User $user
 */
class AbstractAuthUser extends ActiveRecord
{
    /**
     * @param $openID
     *
     * @return array|null|\yii\db\ActiveRecord|\common\models\interfaces\InterfaceUserAuth
     */
    public static function getByOpenID($openID)
    {
        return self::find()->where(['open_id' => $openID])->one();
    }

    public function behaviors()
    {
        return [
            [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'open_id', 'access_token', 'refresh_token', 'access_token_expire_at', 'refresh_token_expire_at'], 'required'],
            [['user_id', 'access_token_expire_at', 'refresh_token_expire_at', 'created_at'], 'integer'],
            [['open_id', 'access_token', 'refresh_token'], 'string', 'max' => 255],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param $userID
     *
     * @return array|null|\yii\db\ActiveRecord|self
     */
    public function getByUserID($userID)
    {
        return self::find()->where(['user_id' => $userID])->one();
    }

    public function connectWithUser(User $user)
    {
        $this->user_id = $user->primaryKey;
        return $this->save();
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    public function needRefreshToken()
    {
        return time() > $this->refresh_token_expire_at;
    }

    public function getIsExpire()
    {
        return time() > $this->refresh_token_expire_at;
    }

    public function updateRefreshToken($newToken)
    {
        $this->refresh_token = $newToken;
        return $this->save(false);
    }

    public function updateAccessToken($newToken)
    {
        $this->access_token = $newToken;
        return $this->save(false);
    }

    public function getOpenID()
    {
        return $this->open_id;
    }

    public function setAccessTokenExpire($timeDuration)
    {
        $this->access_token_expire_at = time() + $timeDuration;
        return $this->save(false);
    }

    public function setRefreshTokenExpire($timeDuration)
    {
        $this->refresh_token_expire_at = time() + $timeDuration;
        return $this->save(false);
    }
}