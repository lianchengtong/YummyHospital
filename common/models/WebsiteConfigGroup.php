<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "website_config_group".
 *
 * @property integer $id
 * @property string  $name
 * @property integer $order
 * @property integer $created_at
 */
class WebsiteConfigGroup extends \common\base\ActiveRecord
{
    public function behaviors()
    {
        $behaviors = [];
        if ($this->enableTimeBehavior) {
            $behaviors[] = [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
            ];
        }

        return $behaviors;
    }

    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'required'],
            [['order', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['order', 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => 'Name',
            'order'      => 'Order',
            'created_at' => 'Created At',
        ];
    }

    public static function getByID($id)
    {
        return self::findOne($id);
    }

    public static function getNameByID($id)
    {
        $model = self::getByID($id);
        if (!$model) {
            return false;
        }

        return $model->name;
    }

    public static function getGroupList()
    {
        $models = self::find()->orderBy(['order' => SORT_ASC, 'created_at' => SORT_ASC])->all();

        return ArrayHelper::map($models, 'id', 'name');
    }
}
