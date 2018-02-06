<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Address;
use common\utils\Json;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\NotFoundHttpException;

class AddressController extends WebController
{
    public function actionSetDefault()
    {
        $model          = $this->getModel();
        $model->default = 1;

        return Json::success($model->save());
    }

    public function actionList()
    {
        $models = Address::getList(UserSession::getId());

        return $this->setViewData([
            'title' => '收货人地址',
        ])->output("page.address-list", [
            'list' => $models,
        ]);
    }

    public function actionDelete()
    {
        $this->getModel()->delete();

        return Json::success();
    }

    public function actionCreate()
    {
        $model          = new Address();
        $model->user_id = UserSession::getId();
        if (Request::isPost() && $model->load(Request::input()) && $model->save()) {
            return $this->redirect(['list']);
        }

        return $this->setViewData([
            'title' => '收货人地址',
        ])->output("page.address-form", [
            'model' => $model,
        ]);
    }

    public function actionUpdate()
    {
        $model          = $this->getModel();
        $model->user_id = UserSession::getId();
        if (Request::isPost() && $model->load(Request::input()) && $model->save()) {
            return $this->redirect(['list']);
        }

        return $this->setViewData([
            'title' => '收货人地址',
        ])->output("page.address-form", [
            'model' => $model,
        ]);
    }

    /**
     * @return array|mixed|Address
     * @throws \yii\web\NotFoundHttpException
     */
    private function getModel()
    {
        $id    = Request::input("id");
        $model = Address::findOne($id);
        if (!$model || $model->user_id != UserSession::getId()) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
