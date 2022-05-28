<?php

namespace core\readModels;

use core\entities\import\ImportTask;

class ImportReadRepository
{
    /***
     * @return \yii\db\BatchQueryResult|ImportTask[]
     */
    public function getToLaunch()
    {
        return ImportTask::find()
            ->where(['status' => ImportTask::STATUS_NEW])
            ->each();
    }

}