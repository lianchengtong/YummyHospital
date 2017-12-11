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
            'user_id'    => 'User ID',
            'role'       => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getUser($userID)
    {
        return self::find()->where(['user_id' => $userID])->one();
    }

    public static function addUserWithRole($userID, $roleID)
    {
        $existUserModel = self::getUser($userID);
        if ($existUserModel) {
            return TRUE;
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
