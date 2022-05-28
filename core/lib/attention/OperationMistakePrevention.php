<?php

namespace core\lib\attention;

use core\lib\attention\operations\Operation;
use rmrevin\yii\fontawesome\FontAwesome;

class OperationMistakePrevention
{
    private $operation;
    private $highlightSum;

    public function __construct(Operation $operation, $highlightSum)
    {
        $this->operation = $operation;
        $this->highlightSum = $highlightSum;
    }

    public function create($sum)
    {
        $icon = FontAwesome::icon($this->operation->icon);
        $text = preg_replace("~\{sum\}~", $sum, $this->operation->text);
        $warning = $sum >= $this->highlightSum ? FontAwesome::i("warning", ['class' => 'text-warning']) . " Большая сумма" : null;

        return $icon . " " . $text . "<br>" . $warning;
    }


}