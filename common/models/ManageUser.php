<?php

namespace common\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "manage_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $role
 * @property integer $created_at
 * @property integer $updated_at
 */
class ManageUser extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manage_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'unique'],
            [['user_id', 'role', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'user_id'    => '用户',
            'role'       => '角色',
            'created_at' => '创建日期',
            'updated_at' => '更新日期',
        ];
    }

    public function beforeSave($insert)
    {
        if (!User::findOne($this->user_id)) {
            $this->addError("user_id", "用户不存在!");

            return false;
        }

        return parent::beforeSave($insert);
    }

    public static function getUser($userID)
    {
        return self::find()->where(['user_id' => $userID])->one();
    }

    public static function addUserWithRole($userID, $roleID)
    {
        $existUserModel = self::getUser($userID);
        if ($existUserModel) {
            return true;
        }

        $model          = new self();
        $model->user_id = $userID;
        $model->role    = $roleID;

        return $model->save();
    }

    public static function getIDList()
    {
        $model = self::find()->select("id")->all();

        return ArrayHelper::getColumn($model, "id");
    }
}
