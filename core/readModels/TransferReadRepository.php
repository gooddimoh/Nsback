<?php

namespace core\readModels;

use core\entities\transfer\Transfer;

class TransferReadRepository
{

    public function getOwn($userId)
    {
        return Transfer::find()->where(['user_id' => $userId]);
    }

}