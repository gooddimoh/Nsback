<?php

namespace core\helpers\product;

use core\entities\import\ImportTask;
use yii\helpers\ArrayHelper;

class ImportHelper
{
    public static function statusList()
    {
        return [
            ImportTask::STATUS_NEW => 'Новый',
            ImportTask::STATUS_PROGRESS => 'В работе',
            ImportTask::STATUS_FINISH => 'Завершен',
            ImportTask::STATUS_STOP => 'Остановлен',
        ];
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

}