<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;
use common\models\CodeBlock;
use common\models\search\CodeBlock as CodeBlockSearch;
use common\utils\Request;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class CodeBlockController extends AuthController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        if (Request::isPost()) {
            $orders = Request::input("order");

            foreach ($orders as $primaryKey => $orderNum) {
                CodeBlock::setOrder($primaryKey, $orderNum);
            }
        }

        $searchModel = new CodeBlockSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->render('list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = CodeBlock::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreate()
    {
        $model = new CodeBlock();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!Request::isAjax()) {
                return $this->redirect(['update', 'id' => $model->primaryKey]);
            }
        }
        if (Request::isAjax()) {
            return $this->renderAjax('update_ajax', [
                'model' => $model,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }
}
