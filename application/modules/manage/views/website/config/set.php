<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WebsiteConfig */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $configGroup [] */
/* @var $configGroupItemList []WebsiteConfig */

$this->title                   = '系统配置';
$this->params['breadcrumbs'][] = $this->title;

$items = [];

//'configGroup'         => $configGroup,
//'configGroupItemList' => $configGroupItemList,
$pointer = 0;
foreach ($configGroup as $groupID => $groupName) {
    $items[] = [
        'label'   => $groupName,
        'content' => $this->render("_form_config", [
            'configItems' => $configGroupItemList[$groupID],
        ]),
        'active'  => $pointer == 0,
    ];
    $pointer++;
}

echo \common\extend\FormTabs::widget([
    'items' => $items,
]);

