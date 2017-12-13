<?php

namespace application\base;

use common\extend\Pagination;
use common\extend\View;
use common\models\Post;
use common\utils\Request;
use common\utils\UserSession;
use Sabre\Xml\Element\Base;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;

class WeChatWebBaseController extends BaseController
{
}