<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;
use common\models\DoctorAppointmentTrack;
use common\models\search\DoctorAppointmentTrack as DoctorAppointmentTrackSearch;
use common\utils\Request;
use common\utils\UserSession;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class AppointmentTrackController extends AuthController
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

    public function actionList($id)
    {
        $model                 = new DoctorAppointmentTrack();
        $model->appointment_id = $id;
        $model->user_id        = UserSession::getId();

        if (Request::isPost() && $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list', 'id' => $id]);
        }

        $searchModel              = new DoctorAppointmentTrackSearch();
        $params                   = Yii::$app->request->queryParams;
        $params['appointment_id'] = $id;
        $dataProvider             = $searchModel->search($params);

        return $this->render('list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'model'        => $model,
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
        $model = new DoctorAppointmentTrack();

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
        if (($model = DoctorAppointmentTrack::findOne($id)) !== NULL) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
