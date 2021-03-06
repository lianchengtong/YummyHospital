<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;
use common\models\PromotionCard;
use common\models\search\PromotionCard as PromotionCardSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class PromotionCardController extends AuthController
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
        $searchModel  = new PromotionCardSearch();
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
        $model = new PromotionCard();

        if ($model->load(Yii::$app->request->post()) && $model->generate()) {
            return $this->redirect(['list']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    //public function actionUpdate($id)
    //{
    //    $model = $this->findModel($id);
    //
    //    if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //        return $this->redirect(['list']);
    //    }
    //    return $this->render('update', [
    //        'model' => $model,
    //    ]);
    //}

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

    protected function findModel($id)
    {
        if (($model = PromotionCard::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
