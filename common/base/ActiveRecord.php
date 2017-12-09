<?php
namespace common\base;


use yii\behaviors\TimestampBehavior;

class ActiveRecord extends \yii\db\ActiveRecord
{
    protected $enableTimeBehavior = TRUE;

    public function behaviors()
    {
        $behaviors = [];
        if ($this->enableTimeBehavior) {
            $behaviors[] = [
                'class' => TimestampBehavior::className(),
            ];
        }

        return $behaviors;
    }

    public static function command($sql, $params)
    {
        return self::getDb()->createCommand($sql, $params);
    }

    public static function tableName()
    {
        $class = array_pop(explode("\\", get_called_class()));
        $class = preg_replace('/([A-Z])/', '_${1}', $class);

        return '{{%' . trim(strtolower($class), "_") . '}}';
    }
}