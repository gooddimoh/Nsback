<?php

namespace frontend\widgets;

use core\entities\communication\Banner;
use yii\base\Widget;
use yii\db\Expression;
use yii\helpers\Html;

class BannerWidget extends Widget
{
    public $location;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        /** @var $banner Banner */
        $banner = Banner::find()->where(['is_active' => 1, 'location' => $this->location])
            ->orderBy(new Expression('rand()'))
            ->one();

        if ($banner === null) {
            return null;
        }

        return Html::a(Html::img($banner->image_url, ['alt' => "Banner"]), $banner->target_url);
    }


}