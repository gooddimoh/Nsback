<?php

namespace core\readModels;

use core\entities\order\OrderHistory;
use yii\data\ActiveDataProvider;

class OrderHistoryReadRepository
{
    public function getByHash($hash)
    {
        return OrderHistory::findOne(['hash' => $hash]);
    }

}