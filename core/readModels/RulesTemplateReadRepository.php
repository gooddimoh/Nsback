<?php

namespace core\readModels;

use core\entities\product\RulesTemplate;

class RulesTemplateReadRepository
{
    public function getForDisplay()
    {
        $list = [];

        foreach (RulesTemplate::find()->asArray()->all() as $template) {
            $list[] = [
                $template['name'],
                $template['content'],
            ];
        }

        return $list;
    }
}