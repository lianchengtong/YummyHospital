<?php

namespace application\modules\manage\controllers\user;

use application\base\AuthController;
use common\models\search\User as UserSearch;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ManageController extends AuthController
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
        $searchModel  = new UserSearch();
        $params       = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->render('list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'isAdmin'      => FALSE,
        ]);
    }

    public function actionAdminList()
    {
        $searchModel  = new UserSearch();
        $params       = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params, TRUE);

        return $this->render('list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'isAdmin'      => TRUE,
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
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== NULL) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
