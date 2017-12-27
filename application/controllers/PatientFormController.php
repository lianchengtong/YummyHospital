<?php

namespace application\controllers;

use application\base\WebController;
use common\models\MyPatient;

class PatientFormController extends WebController
{
    public $layoutSnip = "nav";

    public function actionIndex()
    {
        $model = new MyPatient();

        return $this->render("index", [
            'model' => $model,
        ]);
    }
}
