<?php

namespace core\lib\grid;

use yii\grid\DataColumn;
use yii\helpers\Html;

class StatusColumn extends DataColumn
{
    public $label = 'Инфо-бар';

    public function renderDataCellContent($model, $key, $index)
    {
        if ($this->value !== null) {
            $cells = call_user_func($this->value, $model, $key, $index, $this);

            if (!is_array($cells)) {
                throw new \InvalidArgumentException("Return array in your callback. StatusColumn accept only array.");
            }

            return implode("", array_map(function ($item) {
                return Html::tag("span", "{$item['header']}: {$item['text']}", ['class' => "label label-{$item['type']}"]);
            }, $cells));
        }

        return "";
    }


}