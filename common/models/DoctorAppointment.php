<?php

namespace common\models;

use common\utils\UserSession;

/**
 * This is the model class for table "doctor_appointment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $patient_id
 * @property integer $doctor_id
 * @property integer $time_begin
 * @property integer $time_end
 * @property integer $order_number
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class DoctorAppointment extends \common\base\ActiveRecord
{
    const STATUS_COMPLETE = 0;
    const STATUS_PENDING  = 1;
    const STATUS_CANCEL   = 2;
    const STATUS_BREAK    = 3;

    public static function getStatusDesc($id)
    {
        $list = self::getStatus();

        return $list[$id];
    }

    public static function getStatus()
    {
        return [
            self::STATUS_PENDING  => '进行中',
            self::STATUS_BREAK    => '已爽约',
            self::STATUS_CANCEL   => '已取消',
            self::STATUS_COMPLETE => '已完成',
        ];
    }

    public static function getDayAppointmentCount($doctorID, $year, $month, $day)
    {
        $timeBegin = strtotime(date(sprintf("%s-%s-%s", $year, $month, $day)));
        $timeEnd   = strtotime(date(sprintf("%s-%s-%s 23:59:59", $year, $month, $day)));

        $condition = [
            'and',
            [">", "time_begin", $timeBegin],
            ["<", "time_begin", $timeEnd],
            ["doctor_id" => $doctorID],

        ];

        return self::find()->where($condition)->count();
    }

    public static function getDayTimeAppointmentCount($doctorID, $beginTimestamp, $endTimestamp)
    {
        $condition = [
            'and',
            [">", "time_begin", $beginTimestamp],
            ["<", "time_begin", $endTimestamp],
            ["doctor_id" => $doctorID],
        ];

        return self::find()->where($condition)->count();
    }

    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'user_id'      => '用户',
            'doctor_id'    => '医生',
            'time_begin'   => '开始时间',
            'time_end'     => '结束时间',
            'order_number' => '序号',
            'status'       => '状态',
            'created_at'   => '创建时间',
            'updated_at'   => '更新时间',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->user_id = UserSession::getId();
        }

        $this->time_begin = strtotime($this->time_begin);
        $this->time_end   = strtotime($this->time_end);

        return parent::beforeSave($insert);
    }

    public function rules()
    {
        return [
            [['doctor_id', 'patient_id', 'order_number', 'status'], 'required'],
            [['user_id', 'doctor_id', 'order_number', 'status', 'created_at', 'updated_at'], 'integer'],
            [['time_begin', 'time_end'], 'string'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    public function getPatientInfo()
    {
        return $this->hasOne(MyPatient::className(), ['id' => 'patient_id']);
    }

    public function getFeedback()
    {
        return $this->hasOne(PatientFeedback::className(), [
            'appointment_id' => 'id',
        ]);
    }

    public function getPrice()
    {
        $orderModel = $this->getOrderModel();
        if (!$orderModel) {
            return 0;
        }

        return $orderModel->getPriceYuan();
    }

    public function getOrderModel()
    {
        $condition = [
            'name'    => 'appointment_id',
            'content' => $this->id,
        ];
        /** @var \common\models\OrderMontData $orderMontInfo */
        $orderMontInfo = OrderMontData::find()->where($condition)->one();
        if (!$orderMontInfo) {
            return null;
        }

        /** @var \common\models\Order $orderModel */
        $orderModel = Order::find()
                           ->where(['id' => $orderMontInfo->order_id])
                           ->one();

        return $orderModel;
    }

    public static function callbackPaySuccess(Order $order, $id)
    {
        $model = self::getByID($id);
        if (!$model) {
            throw new \Exception("model not exist for id:" . $id);
        }

        $model->status = self::STATUS_COMPLETE;
        if (!$model->save()) {
            throw new \Exception(self::className() . " callback set complete fail!");
        }
    }
}
