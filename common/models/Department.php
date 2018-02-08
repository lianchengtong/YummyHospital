<?php

namespace common\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "department".
 *
 * @property integer $id
 * @property string  $name
 */
class Department extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    private static $departmentList = [];

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'   => 'ID',
            'name' => '名称',
        ];
    }

    public static function getList()
    {
        if (!empty(self::$departmentList)) {
            return self::$departmentList;
        }

        $models               = self::find()->all();
        self::$departmentList = ArrayHelper::map($models, "id", "name");

        return self::$departmentList;
    }

    public static function getName($id)
    {
        $model = self::findOne($id);
        if (!$model) {
            return false;
        }

        return $model->name;
    }

    public static function getLikeName($name)
    {
        $list = self::find()->where(["like", 'name', $name])->all();

        return ArrayHelper::getColumn($list, "id");
    }
}
