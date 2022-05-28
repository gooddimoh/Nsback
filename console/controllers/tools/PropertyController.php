<?php

namespace console\controllers\tools;

use core\helpers\product\properties\PropertyCommonHelper;
use yii\console\Controller;
use yii\console\ExitCode;

class PropertyController extends Controller
{

    public function actionIsTaken($property)
    {
        $category = PropertyCommonHelper::detectPropertyCategory($property);

        $this->stdout($category ? "This property is taken by $category" : "This property is free!");

        return ExitCode::OK;
    }

}