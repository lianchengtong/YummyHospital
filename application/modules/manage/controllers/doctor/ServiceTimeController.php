<?php

namespace application\modules\manage\controllers\doctor;

use application\base\AuthController;
use common\models\DoctorServiceTime;
use common\models\search\DoctorServiceTime as DoctorServiceTimeSearch;
use common\utils\Json;
use common\utils\Request;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ServiceTimeController extends AuthController
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

    public function actionManage($id)
    {
        $model = DoctorServiceTime::find()->where(['doctor_id' => $id])->one();
        if (!$model) {
            $model            = new DoctorServiceTime();
            $model->doctor_id = $id;
        }

        if (Request::isPost()) {
            $model->load(Request::input());
            if (!$model->save()) {
                return Json::error($model->getErrors());
            }
            $model = DoctorServiceTime::find()->where(['doctor_id' => $id])->one();
        }

        return $this->render("manage", [
            'model' => $model,
        ]);
    }

    public function actionList()
    {
        $searchModel  = new DoctorServiceTimeSearch();
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
        if (($model = DoctorServiceTime::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreate()
    {
        $model = new DoctorServiceTime();

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
