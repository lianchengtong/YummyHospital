<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;
use application\modules\manage\forms\ArticleForm;
use common\models\Article;
use common\models\search\Article as ArticleSearch;
use common\utils\Request;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ArticleController extends AuthController
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
        $searchModel  = new ArticleSearch();
        $params       = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->render('list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new ArticleForm();

        if (Request::isPost() && $model->load(Request::post()) && $model->validate() && $model->save()) {
            return $this->redirect(['list']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = new ArticleForm($id);

        if (Request::isPost() && $model->load(Request::post()) && $model->validate() && $model->save()) {
            return $this->redirect(['list']);
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

    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== NULL) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
