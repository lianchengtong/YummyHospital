<?php

namespace application\modules\manage\controllers;

use Yii;
use common\models\MemberOwnCard;
use common\models\search\MemberOwnCard as MemberOwnCardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use application\base\AuthController;

class MemberOwnCardController extends AuthController
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
        $searchModel = new MemberOwnCardSearch();
        $params = Yii::$app->request->queryParams;
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

    /*public function actionCreate()
    {
        $model = new MemberOwnCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
*/
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

    /*   public function actionDelete($id)
       {
           $this->findModel($id)->delete();

           return $this->redirect(['list']);
       }
       */

    protected function findModel($id)
    {
        if (($model = MemberOwnCard::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
