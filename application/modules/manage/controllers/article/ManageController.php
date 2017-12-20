<?php

namespace application\modules\manage\controllers\article;

use application\base\AuthController;
use application\modules\manage\forms\ArticleForm;
use common\models\Article;
use common\models\ArticleType;
use common\models\search\Article as ArticleSearch;
use common\utils\Request;
use Yii;
use yii\base\InvalidParamException;
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

    public function actionSelect()
    {
        $models = ArticleType::find()->orderBy(['order' => SORT_ASC])->all();
        return $this->render("select", [
            'models' => $models,
        ]);
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

    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreate()
    {
        $type = Request::input("type");
        if (empty($type)) {
            throw new InvalidParamException("missing param type");
        }

        $typeModel = ArticleType::getBySlug($type);
        if (!$typeModel) {
            throw new InvalidParamException("type is invalid!");
        }

        $model       = new ArticleForm();
        $model->type = $typeModel->id;

        if (Request::isPost() && $model->load(Request::post()) && $model->validate() && $model->save()) {
            return $this->redirect(['list']);
        }

        return $this->render('create', [
            'model'      => $model,
            'typeFields' => $typeModel->inputFields,
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
}
