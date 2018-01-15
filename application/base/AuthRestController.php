<?php

namespace application\base;

use yii\rest\Controller;
use yii\web\Response;

class AuthRestController extends Controller
{
    use TraitNeedLoginAdmin;
}