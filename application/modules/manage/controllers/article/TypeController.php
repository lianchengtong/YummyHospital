<?php

namespace application\modules\manage\controllers\article;

use application\base\AuthController;
use common\models\ArticleType;
use common\models\search\ArticleType as ArticleTypeSearch;
use common\utils\Request;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class TypeController extends AuthController
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
                ArticleType::setOrder($primaryKey, $orderNum);
            }
        }

        $searchModel  = new ArticleTypeSearch();
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

    protected function findModel($id)
    {
        if (($model = ArticleType::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreate()
    {
        $model = new ArticleType();

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
}
