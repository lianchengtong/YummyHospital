<div class="ui-page-my-card">
    <div class="card-img mb-20">
        <img src="/images/banner/banner-1.jpg" alt="">
    </div>

    <div class="icon-show">
        <ul class="ui-tiled">
            <li class="ui-txt-center" style="border-right: 1px solid #efefef">
                <i class="ui-icon-wallet"></i>
                <div class="ui-txt-info">余额</div>
                <div class="money">&yen; <?= 1 ?></div>
            </li>
            <li class="ui-text-center">
                <a href="/card/index">
                    <i class="ui-icon-gototop"></i>
                    <div class="ui-txt-info">VIP</div>
                    <div class="money">升级</div>
                </a>
            </li>
        </ul>
    </div>

    <div class="info">
        <div class="item flex-item phone">
            <div class="label">手机</div>
            <div class="data">
                <?= $model->user->phone ?>
            </div>
        </div>
        <a href="/card/history" class="item ui-arrowlink">
            账单
        </a>
        <div class="item info">
            <?= $model->card->description ?>
        </div>
    </div>
</div>