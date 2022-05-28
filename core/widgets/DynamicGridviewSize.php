<?php

namespace core\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class DynamicGridviewSize extends Widget
{
    public $perPageValues = [10, 20, 100, 200];
    public $dataProvider;
    public $selectOptions = [
        'class' => 'form-control',
    ];

    public function init()
    {
        parent::init();
        if (!$this->dataProvider instanceof ActiveDataProvider) {
            throw new \InvalidArgumentException("dataProvider attribute must be instance of ActiveDataProvider");
        }
        if (!is_array($this->perPageValues)) {
            throw new \InvalidArgumentException("perPageValues must be array");
        }
        foreach ($this->perPageValues as $pageValue) {
            if (!is_numeric($pageValue)) {
                throw new \DomainException("All values in perPageValues must be numeric");
            }
        }
    }

    public function run()
    {
        $options = null;
        $currentPageSize = $this->dataProvider->getPagination()->getPageSize();

        foreach ($this->perPageValues as $perPageValue) {
            $optionValue = Html::encode(Url::current(['per-page' => $perPageValue, 'page' => null]));
            $isSelected = $currentPageSize === $perPageValue ? 'selected' : "";
            $options .= "<option value='$optionValue' $isSelected>$perPageValue</option>";
        }

        return Html::tag("select", $options, array_merge($this->selectOptions, [
            'onchange' => 'location = this.value',
        ]));
    }


}