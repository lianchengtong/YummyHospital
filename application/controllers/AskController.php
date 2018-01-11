<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Doctor;
use common\models\Order;
use common\models\OrderMontData;
use common\models\PatientAsk;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\ForbiddenHttpException;

class AskController extends WebController
{
    public function actionIndex($id)
    {
        $model = new PatientAsk();
        if (!($doctorModel = Doctor::findOne($id))) {
            throw new ForbiddenHttpException();
        }
        $model->doctor_id = $id;
        $model->patient_id = Request::input("patient");
        $model->user_id = UserSession::getId();

        if (Request::isPost() && $model->load(Request::input())) {
            $trans = \Yii::$app->getDb()->beginTransaction();
            try {
                if (!$model->save()) {
                    throw new \Exception("save ask form fail");
                }

                $title = sprintf("咨询 %s %s的病情",
                    $doctorModel->name,
                    $model->patient->name
                );

                $orderModel = Order::create(UserSession::getId(), $title, $doctorModel->ask_price);
                if ($orderModel === false) {
                    throw new \Exception("create order failed");
                }

                $montData = OrderMontData::addData($orderModel->primaryKey, PatientAsk::rawTableName(), $model->primaryKey);
                if (true !== $montData) {
                    throw new \Exception("save montdata patient_ask_id fail");
                }

                $montDataCallback = OrderMontData::getCallback(PatientAsk::className(), "callbackPaySuccess", [$model->id]);
                $montData = OrderMontData::addData($orderModel->primaryKey, "callback", $montDataCallback);
                if (true !== $montData) {
                    throw new \Exception("save order montdata callback fail");
                }

                $trans->commit();

                return $this->redirect(['list']);
            } catch (\Exception $e) {
                $trans->rollBack();
                $this->addError($e->getMessage());
            }
        }

        return $this->setViewData([
            'title'   => "门诊预约",
            'showTab' => false,
        ])->output("page.patient-ask-form", [
            'model'       => $model,
            'doctorModel' => $doctorModel,
        ]);

    }

    public function actionList()
    {
        $models = PatientAsk::getModelList(UserSession::getId());

        return $this->setViewData([
            'title' => "我的咨询",
        ])->output("page.my-ask-history-list", [
            'models' => $models,
        ]);
    }
}
