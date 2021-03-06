<?php

namespace application\base;

use application\builder\Code;
use common\extend\View;
use common\utils\Request;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;

class BaseController extends Controller
{
    public    $layoutSnip    = "main";
    public    $pageItemCount = 10;
    protected $errors        = [];
    protected $hackMode      = false;

    public function init()
    {
        parent::init();
        if ($this->module->uniqueId == "manage") {
            \Yii::$app->getErrorHandler()->errorAction = Url::to("@admin/error");
        }
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function goBack($defaultUrl = null)
    {
        return parent::goBack(Request::input("__returnUrl"));
    }


    /**
     * @return \yii\base\View|\yii\web\View|View
     */
    public function getView()
    {
        return parent::getView();
    }

//    public function getRoute()
//    {
//        $route = parent::getRoute();
//        if (substr($route, -6) == "/index") {
//            $route = substr($route, 0, -6);
//        }
//
//        return $route;
//    }

    public function renderContent($content)
    {
        $layoutFile = $this->findLayoutFile($this->getView());
        if ($layoutFile !== false) {
            $snipFile = "__" . $this->layoutSnip;

            return $this->getView()->renderFile($layoutFile, [
                'content' => $content,
                'snip'    => $snipFile,
            ], $this);
        }

        return $content;
    }

    /**
     * @param string|array $view
     * @param array        $params
     *
     * @return string
     */
    public function render($view = [], $params = [])
    {
        if (empty($view)) {
            return parent::render("index");
        }

        if (is_array($view)) {
            return parent::render("index", $view);
        }

        return parent::render($view, $params);
    }

    public function setViewData($viewSettings = [])
    {
        foreach ($viewSettings as $key => $value) {
            $this->getView()->$key = $value;
        }

        return $this;
    }

    public function output($codeID, $params = [], $viewSettings = [])
    {
        $params["errors"]     = $this->errors;
        $this->view->errors   = $this->errors;
        $this->view->uniqueID = $this->action->uniqueId;

        if ($this->hackMode) {
            return $this->render(sprintf("//%s.php", $codeID), $params);
        }

        $this->setViewData($viewSettings);
        $content = Code::output($codeID, $params);

        return $this->renderContent($content);
    }

    public function addError($errorMsg)
    {
        $this->errors[] = Html::encode($errorMsg);
    }
}