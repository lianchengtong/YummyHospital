<?php

namespace application\controllers;

use application\base\WebController;

class AppointmentController extends WebController
{
    public function actionIndex()
    {
        $tagName = \common\utils\Request::input("tag");
        $items   = \common\utils\Cache::dataProvider(
            "page.doctor-appointment-list-" . $tagName,
            function () use ($tagName) {
                return \common\models\Doctor::getByTag($tagName);
            }
        );

        $viewSettings = [
            'title'      => "门诊预约",
            'showGoBack' => false,
        ];

        return $this->output("page.doctor-appointment-list", [
            'items' => $items,
        ], $viewSettings);
    }
}
