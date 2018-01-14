<div class="row ui-page-appointment">
    <ul class="ui-list ui-border-tb">
        <?php foreach ($items as $item): ?>
            <?php
            $url = ['/doctor', 'id' => $item->id];
            ?>
            <li class="doctor-list">
                <a href="<?= \yii\helpers\Url::to($url) ?>" class="ui-avatar">
                    <?= \yii\helpers\Html::img($item->head_image) ?>
                </a>
                <div class="ui-list-info ui-border-t">
                    <div class="ui-row-flex">
                        <div class="ui-col doctor-info">
                            <h4 class="ui-nowrap mb-5">
                                <?= \yii\helpers\Html::a($item->name, $url, ['class' => 'doctor-name']) ?>
                                <span class="subtitle"><?= $item->levelModel->level_name ?></span>
                            </h4>
                            <div class="ui-label-list ui-no-margin mb-5">
                                <span class="ui-label-head">擅长:</span>

                                <?php foreach ($item->departments as $department): ?>
                                    <label class="ui-label-s"><?= $department->department->name ?></label>
                                <?php endforeach; ?>
                            </div>
                            <p class="ui-desc">
                                <span>
                                    评分：
                                    <span class="count"><?=\common\models\PatientFeedback::getDoctorMark($item->id)?></span>
                                    |
                                </span>

                                <span>
                                    评价：
                                    <span class="count"><?=\common\models\PatientFeedback::count(["doctor_id"=>$item->id])?></span>
                                    |
                                </span>
                                <span>
                                    接诊：
                                    <span class="count"><?=\common\models\DoctorAppointment::count(["doctor_id"=>$item->id,"status"=>"0"])?></span>
                                </span>
                            </p>
                        </div>
                        <div class="ui-flex ui-flex-ver ui-flex-pack-center ui-flex-align-center ui-btn-group-wrapper">
                            <div class="ui-txt-center mb-20 price">&yen;<?=$item->doctorServiceTime->price?></div>
                            <a href="<?= \yii\helpers\Url::to($url) ?>" class="ui-btn-s">立即预约</a>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
