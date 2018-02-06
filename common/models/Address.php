<?php

namespace common\models;

/**
 * This is the model class for table "address".
 *
 * @property int    $id
 * @property int    $user_id
 * @property string $name
 * @property string $phone
 * @property string $location
 * @property int    $default
 */
class Address extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public function rules()
    {
        return [
            [['user_id', 'name', 'phone', 'location'], 'required'],
            [['user_id', 'default'], 'integer'],
            [['name', 'phone', 'location'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'user_id'  => 'User ID',
            'name'     => 'Name',
            'phone'    => 'Phone',
            'location' => 'Location',
            'default'  => 'Default',
        ];
    }

    public function beforeSave($insert)
    {
        $currentCount = self::find()->where(['user_id' => $this->user_id])->count();
        if ($currentCount == 0) {
            $this->default = 1;
        }

        return parent::beforeSave($insert);
    }

    public static function getList($userID)
    {
        $condition = [
            'user_id' => $userID,
        ];

        return self::find()->where($condition)->orderBy([
            'default' => SORT_DESC,
            'id'      => SORT_DESC,
        ])->all();
    }
}
