<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Address;
use common\utils\Request;
use common\utils\UserSession;

class AddressController extends WebController
{
    public function actionList()
    {
        $models = Address::getList(UserSession::getId());

        return $this->render("//test");

        return $this->setViewData([
            'title'   => '我的订单',
            'showTab' => 'false',
        ])->output("page.order-list", [
            'models' => $models,
        ]);
    }

    public function actionCreate()
    {
        $model = new Address();
        if (Request::isPost() && $model->load(Request::input()) && $model->save()) {
            return $this->redirect(['list']);
        }

        return $this->render("//form", [
            'model' => $model,
        ]);
    }

    private function getModel()
    {
        $id = Request::input("id");

        return $id;
    }
}
