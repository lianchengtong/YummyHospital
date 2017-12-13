<?php

namespace common\extend;

use common\models\WebsiteConfig;

class Url extends \yii\helpers\Url
{
    public static function full($url = '')
    {
        $siteDomain = WebsiteConfig::getValueByKey("site.domain");
        return sprintf("%s/%s", rtrim($siteDomain, "/"), ltrim(parent::to($url), "/"));
    }
}
