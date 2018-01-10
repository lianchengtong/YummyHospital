<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "promotion_card".
 *
 * @property int    $id
 * @property int    $user_id
 * @property string $card_number
 * @property int    $card_worth
 * @property string $batch_code
 * @property int    $active_at
 * @property int    $created_at
 */
class PromotionCard extends \common\base\ActiveRecord
{
    public $template;
    public $count;

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
            [['user_id', 'card_worth', 'active_at', 'created_at'], 'integer'],
            [['card_number', 'card_worth', 'batch_code'], 'required'],
            [['card_number', 'batch_code'], 'string', 'max' => 255],
            [['template', 'count'], 'safe'],
            [['count'], 'integer'],
            [['count'], 'in', 'range' => range(1, 100)],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'user_id'     => '用户',
            'card_number' => '卡号',
            'card_worth'  => '面值',
            'batch_code'  => '识别码',
            'active_at'   => '激活日期',
            'created_at'  => '创建日期',
            'template'    => '模板',
            'count'       => '数量',
        ];
    }

    public function attributeHints()
    {
        return [
            'template'   => '示例：{date} 日期, {time} 时间, {string:N} N位随机字母，{number:N} N位随机数字(N最大为10,最小为1), N可以自定义长度,几种关键词自由组合，生成结果最长支持250位',
            'count'      => '每次生成不要超过100张，否则可能生成失败！',
            'card_worth' => '单位：元',
            'batch_code' => '用于区分生成批次，如需要补充卡直接输入需要补充卡的批次识别码即可',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param $cardNumber
     *
     * @return array|null|\yii\db\ActiveRecord|self
     */
    public static function getByCardNumber($cardNumber)
    {
        return self::find()->where(['card_number' => $cardNumber])->one();
    }

    public static function activeForUser($cardNumber, $userID)
    {
        $model = self::getByCardNumber($cardNumber);
        if ($model->user_id != 0) {
            return false;
        }

        $model->user_id   = $userID;
        $model->active_at = time();

        return $model->saveOrError();
    }

    public static function createCard($template, $count, $worth, $code)
    {
        for ($i = 0; $i < $count; $i++) {
            $model              = new self();
            $model->batch_code  = $code;
            $model->card_worth  = $worth;
            $model->card_number = self::generateByTemplate($template);
            $model->save();
        }

        return true;
    }

    public static function generateByTemplate($template)
    {
        $pattern = '/\{(\w+):(\d+)\}/';
        preg_match_all($pattern, $template, $matches);

        $metaData = [];
        foreach ($matches[0] as $index => $key) {
            $metaData[$key] = [$matches[1][$index], $matches[2][$index]];
        }

        $replaceData = [
            '{date}' => date("Ymd"),
            '{time}' => date("His"),
        ];
        foreach ($metaData as $placeholder => $data) {
            list($type, $len) = $data;
            $len = intval($len);
            switch ($type) {
                case "number":
                    if ($len > 10) {
                        $len = 10;
                    }
                    if ($len < 1) {
                        $len = 1;
                    }
                    $replaceData[$placeholder] = mt_rand(pow(10, $len - 1), pow(10, $len) - 1);
                    break;
                case "string":
                    $replaceData[$placeholder] = \Yii::$app->getSecurity()->generateRandomString($len);
                    break;
            }
        }

        return strtoupper(strtr($template, $replaceData));
    }

    public function generate()
    {
        return self::createCard($this->template, $this->count, $this->card_worth, $this->batch_code);
    }
}
