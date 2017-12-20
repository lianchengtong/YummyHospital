<?php

namespace application\modules\manage\controllers\article;

use application\base\AuthController;
use common\models\ArticleType;
use common\models\ArticleTypeField;
use common\models\search\ArticleTypeField as ArticleTypeFieldSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class FieldController extends AuthController
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
        $typeModel = ArticleType::findOne($id);
        if (!$typeModel) {
            throw new NotFoundHttpException();
        }

        $searchModel                                 = new ArticleTypeFieldSearch();
        $params                                      = Yii::$app->request->queryParams;
        $params[$searchModel->formName()]['type_id'] = $id;
        $dataProvider                                = $searchModel->search($params);


        return $this->render('list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'typeModel'    => $typeModel,
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
        if (($model = ArticleTypeField::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreate($type)
    {
        $typeModel = ArticleType::findOne($type);
        if (!$typeModel) {
            throw new NotFoundHttpException();
        }

        $model          = new ArticleTypeField();
        $model->type_id = $typeModel->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list', 'id' => $model->type_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list', 'id' => $model->type_id]);
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
