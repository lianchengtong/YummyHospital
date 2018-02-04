<?php

namespace application\modules\manage\controllers\link;

use application\base\AuthController;
use common\models\LinkGroup;
use common\models\LinkGroupItem;
use common\models\search\LinkGroupItem as LinkGroupItemSearch;
use common\utils\Request;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ItemController extends AuthController
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
            $orderList = Request::post("order");
            foreach ($orderList as $id => $newOrder) {
                LinkGroupItem::updateAll(['order' => intval($newOrder)], ['id' => $id]);
            }
        }
        $linkGroupModel = LinkGroup::findOne(Request::input("group"));
        if (!$linkGroupModel) {
            throw new NotFoundHttpException();
        }

        $searchModel                                       = new LinkGroupItemSearch();
        $params                                            = Request::input();
        $params[$searchModel->formName()]['link_group_id'] = $linkGroupModel->id;
        $dataProvider                                      = $searchModel->search($params);

        return $this->render('list', [
            'searchModel'    => $searchModel,
            'dataProvider'   => $dataProvider,
            'linkGroupModel' => $linkGroupModel,
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
        $group = Request::input("group");
        if (!$group) {
            throw new InvalidParamException("group");
        }
        $groupModel = LinkGroup::findOne($group);
        if (!$groupModel) {
            throw new NotFoundHttpException("group not exist");
        }

        $model                = new LinkGroupItem();
        $model->link_group_id = $group;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list', 'group' => $model->link_group_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list', 'group' => $model->link_group_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $groupID = $model->link_group_id;
        $model->delete();

        return $this->redirect(['list', 'group' => $groupID]);
    }

    protected function findModel($id)
    {
        if (($model = LinkGroupItem::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
