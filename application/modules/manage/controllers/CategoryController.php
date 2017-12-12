<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;
use common\models\Category;
use common\utils\Request;
use yii\data\ArrayDataProvider;

class CategoryController extends AuthController
{
    public function actionList()
    {
        if (Request::isPost()) {
            $orderList = Request::post("order");
            foreach ($orderList as $id => $newOrder) {
                Category::updatePath();
                Category::updateAll(['order' => intval($newOrder)], ['id' => $id]);
            }
        }

        $sortList = Category::getFlatIndentList();
        $dataList = Category::getList();

        $sortDataList = [];
        foreach ($sortList as $id => $value) {
            $data           = $dataList[$id];
            $data['name']   = $value;
            $sortDataList[] = $data;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels'  => $sortDataList,
            'pagination' => [
                'pageSize' => 10 * 10000,
            ],
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($id)
    {
        $model = new Category();
        if (Request::isPost() && $model->load(Request::post()) && $model->save()) {
            Category::updatePath();

            return $this->redirect("@admin/category/list");
        }
        $model->pid = $id;

        return $this->render('operate', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Category::findOne($id);
        if (Request::isPost() && $model->load(Request::post()) && $model->save()) {
            Category::updatePath();

            return $this->redirect("@admin/category/list");
        }

        return $this->render('operate', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $deleteItemTree = Category::getSubTree($id, TRUE);
        if (count($deleteItemTree)) {
            Category::updatePath();
            Category::deleteAll(['id' => array_keys($deleteItemTree)]);
        }

        return $this->redirect("@admin/category/list");
    }
}
