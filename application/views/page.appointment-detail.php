<?php
/** @var $model \common\models\DoctorAppointment */
/** @var \common\models\Order $orderInfo */
$orderInfo = \common\models\OrderMontData::getOrderIDByName(\common\models\Department::rawTableName());
?>
<div class="ui-page-appointment-cancel">
    <div class="widget doctor-info mb-20">
        <?= \yii\helpers\Html::img($model->doctor->head_image) ?>
        <div class="info">
            <?= sprintf("<span class='name'>%s</span> %s", $model->doctor->name, $model->doctor->levelModel->level_name) ?>
        </div>
    </div>

    <ul class="widget-item-list mb-20">
        <li>
            <div class="label">就诊医院</div>
            <div class="data">汉典中医医院</div>
        </li>
        <li>
            <div class="label">就诊科室</div>
            <div class="data"><?=123?></div>
        </li>
        <li>
            <div class="label">就诊地址</div>
            <div class="data">朝阳区石佛营东里133号</div>
        </li>
        <li>
            <div class="label">预约时间</div>
            <div class="data">2017-01-07 14:30:00</div>
        </li>
    </ul>

    <ul class="widget-item-list">
        <li>
            <div class="label">就诊人</div>
            <div class="data">李晓每</div>
        </li>
        <li>
            <div class="label">性别</div>
            <div class="data">女</div>
        </li>
        <li>
            <div class="label">生日</div>
            <div class="data">1980-01-01</div>
        </li>
        <li>
            <div class="label">预约手机</div>
            <div class="data">152123123123</div>
        </li>
    </ul>

    <ul class="widget-item-list">
        <li>
            <div class="label">支付方式</div>
            <div class="data">支付宝</div>
        </li>
        <li>
            <div class="label">下单时间</div>
            <div class="data">123123123</div>
        </li>
    </ul>

    <div class="m-20 ui-txt-info">
        温馨提示：取消预约前请认真阅读 <a href="/appointment/cancel">取消预约须知</a>
    </div>

    <div class="widget">
        <a href="/appointment/cancel-order?id=<?= $model->id ?>" onclick="return confirm('确定要取消预约么？')"
           class="ui-btn-lg ui-btn-main">取消预约</a>
    </div>
</div>