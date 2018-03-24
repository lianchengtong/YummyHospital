<?php
$departments = \common\models\Department::find()->all();
$orderType   = [
    'default' => '默认排序',
    'mark'    => '评分排序',
];

$departmentMap   = \yii\helpers\ArrayHelper::map($departments, "id", "name");
$orderValue      = \common\utils\Request::input("order", "default");
$departmentValue = \common\utils\Request::input("department", "");
?>
<div class="doctor-filter-box">
    <div class="doctor-filter">
        <div class="item department-filter"
             data-id="department-filter-items"><?= empty($departmentValue) ? "全部科室" : $departmentValue ?></div>
        <div class="item sort-filter" data-id="sort-filter-items"><?= $orderType[$orderValue] ?></div>
    </div>
    <div class="filter-mask"></div>
    <div class="doctor-filter-items">
        <div class="filter-item" id="department-filter-items">
            <?php
            echo \yii\helpers\Html::a("全部科室", ["/appointment/ask", 'department' => ""], [
                'class' => 'ui-btn ui-btn-main',
            ]);
            foreach ($departments as $department) {
                echo \yii\helpers\Html::a($department->name, ["/appointment/ask", 'department' => $department->name], [
                    'class' => 'ui-btn ui-btn-main',
                ]);
            }
            ?>
        </div>
        <div class="filter-item" id="sort-filter-items">
            <?php
            foreach ($orderType as $key => $value) {
                echo \yii\helpers\Html::a($value, ["/appointment/ask", 'order' => $key], [
                    'class' => 'ui-btn ui-btn-main',
                ]);
            }
            ?>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("body").on("tap", ".doctor-filter .item", function () {
            $(".filter-item").hide();

            var targetID = $(this).attr("data-id");
            $("#" + targetID).toggle();
            $(".filter-mask").show();
        });

        $("body").on("tap", ".filter-mask", function () {
            $(this).hide();
            $(".filter-item").hide();
        });
    })
</script>
