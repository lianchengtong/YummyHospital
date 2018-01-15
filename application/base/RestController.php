<?php
namespace application\base;

use yii\rest\Controller;
use yii\web\Response;

class RestController extends Controller
{
    public function behaviors()
    {
        $behaviors                                 = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
        ];

        return $behaviors;
    }
}