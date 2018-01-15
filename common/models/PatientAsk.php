<?php

namespace common\models;

use common\utils\WeChatInstance;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "patient_ask".
 *
 * @property integer                  $id
 * @property integer                  $user_id
 * @property integer                  $doctor_id
 * @property integer                  $patient_id
 * @property string                   $description
 * @property string                   $images
 * @property string                   $reply
 * @property integer                  $reply_at
 * @property integer                  $pay_status
 * @property integer                  $created_at
 * @property integer                  $updated_at
 *
 * @property \common\models\MyPatient $patient
 * @property \common\models\Doctor    $doctor
 */
class PatientAsk extends \common\base\ActiveRecord
{
    const STATUS_PENDING_PAY = 0;
    const STATUS_PAY_CLOSED  = 1;
    const STATUS_PAY_SUCCESS = 2;

    public function rules()
    {
        return [
            [['user_id', 'doctor_id', 'patient_id', 'description'], 'required'],
            [['user_id', 'patient_id', 'reply_at', 'created_at', 'updated_at'], 'integer'],
            [['description', 'images', 'reply'], 'string'],
            [['description'], 'string', 'min' => 5, 'max' => 250, 'message' => '请最少输入5个字,最多输入240个字'],
            [['pay_status'], 'default', 'value' => self::STATUS_PENDING_PAY],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'user_id'       => '用户',
            'patient_id'    => '患者',
            'description'   => '描述',
            'images'        => '图片',
            'reply'         => '回复内容',
            'reply_at'      => '回复日期',
            'created_at'    => '创建日期',
            'updated_at'    => '更新日期',
            'doctor.name'   => '医生',
            'patient.name'  => '患者',
            'user.nickname' => '用户',
        ];
    }

    public static function getModelList($userID)
    {
        $models = self::find()->where(['user_id' => $userID])->orderBy(['id' => SORT_DESC])->all();

        return $models;
    }

    public function getPatient()
    {
        return $this->hasOne(MyPatient::className(), ['id' => 'patient_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getImageList()
    {
        return array_filter(explode(",", $this->images));
    }

    public function setPayStatus($status)
    {
        $this->pay_status = $status;

        return $this->save();
    }

    public static function callbackPaySuccess(Order $order, $id)
    {
        $model = self::getByID($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        $model->pay_status = self::STATUS_PAY_SUCCESS;
        if (!$model->save()) {
            throw new \Exception(self::className() . " callback set complete fail");
        }


/*        WeChatInstance::officialAccount()->template_message->send([
            'touser'      => $order->wechatAuth->openid,
            'template_id' => 'PD-m5F_le-Y2aSXEXDflFkXM552VO1tmzEYhdsU4jc8',
            'scene'       => 1000,
            'url'         => '',
            'data'        => [
                'first'    => '咨询成功',
                'keyword1' => "在线咨询",
                'keyword2' => "成功",
                'keyword3' => date("Y-m-d H:i:s", $order->complete_at),
                'remark'   => "您咨询的医师将会尽快为您解答问题,请耐心等待。",
            ],
        ]);
*/
    }

    public function getIsPayed()
    {
        $order = OrderMontData::getOrder(self::rawTableName(), $this->id);
        if (!$order || !$order->getIsPaySuccess()) {
            return false;
        }

        if ($order->price == 0) {
            return true;
        }

        return true;
    }

    public function getOrderID()
    {
        $order = OrderMontData::getOrder(self::rawTableName(), $this->id);
        if (!$order || $order->getIsPaySuccess()) {
            return false;
        }

        return $order->order_id;
    }
}
