<section class="ui-panel ui-doctor-appointment-tab">
    <div class="ui-panel-heading">
        <ul class="ui-tiled ui-tab-list">
            <li data-id="0" class="active">预约挂号</li>
            <li data-id="1">在线咨询</li>
        </ul>
    </div>

    <div class="ui-panel-body">
        <div class="ui-tab-item-content ui-tab-item-0 ui-hide ui-show">
            <ul class="ui-doctor-appointment-list">
                <?php
                $serviceDate   = \common\models\DoctorServiceTime::getAllRecentServiceTimeDateList($model->id, false);
                $showItemIndex = 0;
                foreach ($serviceDate as $dateKey => $date) {
                    $showItem = $showItemIndex == 0;
                    $showItemIndex++;
                    ?>
                    <li class="ui-border-b">
                        <span class="time"><?= $date ?></span>
                        <span class="location">汉典中医院</span>
                        <span class="price">&yen; <?= $model->doctorServiceTime->price ?></span>
                        <span class="btn-wrapper"><button href="<?= $dateKey ?>" class="ui-btn toggle-sidebar">预约</button></span>
                    </li>
                    <?php
                }
                ?>

            </ul>
            <div class="ui-btn-show-all" data-toggle="0">查看全部排班</div>
        </div>
        <div class="ui-tab-item-content ui-tab-item-1 p-20 ui-hide ">
            <?php if ($model->enable_ask) { ?>
                <?= \yii\helpers\Html::a("立即咨询", ["ask/index", "id" => $model->id]) ?>
            <?php } else { ?>
                <div class="ui-align-center">
                    对不起，此医师暂未开通咨询功能！
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<div id="sidebar">
    <!--
    simpler-sidebar will handle #sidebar's position.

    To let the content of your sidebar overflow, especially when you have a lot of content in it, you have to add a "wrapper" that wraps all content.

    TIP: provide a background color.
    -->
    <div id="sidebar-wrapper" class="sidebar-wrapper">
        <?php for ($i = 0; $i < 100; $i++): ?>
            <p>slide show content</p>
        <?php endfor; ?>
    </div>
</div>


<script>
    $(function () {
        $("body").on("tap",".toggle-sidebar",function(){
            $("#sidebar-wrapper").html("hello world!");
        });
        $("#sidebar").simplerSidebar({
            selectors: {
                trigger: ".toggle-sidebar",
                quitter: ".close-sidebar"
            }
        });

        $("body").on("tap", ".ui-tab-item-content .ui-btn-show-all", function () {
            if ($(this).attr("data-toggle") == 0) {
                $(".ui-doctor-appointment-list").attr('style', "height: auto;")
                $(this).attr("data-toggle", 1);
                $(this).text("折叠全部排班");
            } else {
                $(".ui-doctor-appointment-list").attr('style', "height: 60px;")
                $(this).attr("data-toggle", 0);
                $(this).text("查看全部排班");
            }
        });

        $("body").on("tap", ".ui-tab-list li", function () {
            var panelWrapper = $(this).closest(".ui-panel");
            if ($(this).hasClass("active")) {
                return;
            }

            $(panelWrapper).find(".ui-panel-heading li").removeClass("active");
            $(this).addClass("active");

            var _tabID = $(this).attr("data-id");
            $(panelWrapper).find(".ui-panel-body .ui-tab-item-content").removeClass("ui-show");
            $(panelWrapper).find(".ui-panel-body .ui-tab-item-" + _tabID).addClass("ui-show");
        });
    })
</script>