<?php

use yii\helpers\Html;

/** @var  $prevMonth array */
/** @var  $nextMonth array */
/** @var  $showPrevLink bool */
/** @var  $doctorID integer */
/** @var  $currentMonth string */
/** @var  $calendarHtml string */

$prevMonthLink = [
    "/service-calendar",
    'year'  => $prevMonth['year'],
    'month' => $prevMonth['month'],
    'id'    => $doctorID,
];

$nextMonthLink = [
    "/service-calendar",
    'year'  => $nextMonth['year'],
    'month' => $nextMonth['month'],
    'id'    => $doctorID,
];
?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <strong><?= $currentMonth ?></strong>
        <div class="pull-right">
            <?= $showPrevLink == true ? Html::a("上一月", $prevMonthLink) : "" ?>
            <?= Html::a("下一月", $nextMonthLink) ?>
        </div>
    </div>
    <?= $calendarHtml ?>
</div>
