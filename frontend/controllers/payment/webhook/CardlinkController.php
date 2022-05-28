<?php

namespace frontend\controllers\payment\webhook;

use yii\rest\Controller;

class CardlinkController extends Controller
{

    # /payment/webhook/cardlink/callback
    public function actionCallback()
    {
        return [
            'status' => 'ok',
        ];
    }

}