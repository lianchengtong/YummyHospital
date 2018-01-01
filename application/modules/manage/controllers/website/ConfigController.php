<?php

namespace application\modules\manage\controllers\website;

use application\base\AuthController;
use common\models\search\WebsiteConfig as WebsiteConfigSearch;
use common\models\search\WebsiteConfigGroup;
use common\models\WebsiteConfig;
use common\utils\Request;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ConfigController extends AuthController
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

    public function actionSet()
    {
        if (Request::isPost()) {
            $postForm = Request::input((new WebsiteConfig())->formName(), []);
            $listData = WebsiteConfig::getAll();
            foreach ($postForm as $key => $value) {
                if (is_array($value)) {
                    $value = implode(",", $value);
                }

                if ($listData[$key] == $value) {
                    continue;
                }

                WebsiteConfig::set($key, $value);
            }
            WebsiteConfig::clearCache();
        }

        $configGroup   = WebsiteConfigGroup::getGroupList();
        $websiteConfig = WebsiteConfig::find()->orderBy(['order' => SORT_DESC, 'created_at' => SORT_ASC])->all();

        $configGroupItemList = [];
        /** @var WebsiteConfig $configItem */
        foreach ($websiteConfig as $configItem) {
            $configGroupItemList[$configItem->group_id][] = $configItem;
        }

        return $this->render('set', [
            'configGroup'         => $configGroup,
            'configGroupItemList' => $configGroupItemList,
        ]);
    }

    public function actionList()
    {
        $searchModel  = new WebsiteConfigSearch();
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
        $model = new WebsiteConfig();

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
        if (($model = WebsiteConfig::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
