<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;
use common\models\DoctorAppointment;
use common\models\search\DoctorAppointment as DoctorAppointmentSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class AppointmentController extends AuthController
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

    public function actionRecent()
    {
        $searchModel  = new DoctorAppointmentSearch();
        $params       = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params, TRUE);

        return $this->render('list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'isRecent'     => TRUE,
        ]);
    }

    public function actionAll()
    {
        $searchModel  = new DoctorAppointmentSearch();
        $params       = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->render('list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'isRecent'     => FALSE,
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
        $model = new DoctorAppointment();

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

    protected function findModel($id)
    {
        if (($model = DoctorAppointment::findOne($id)) !== NULL) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
