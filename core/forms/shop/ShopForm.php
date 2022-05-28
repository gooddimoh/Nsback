<?php

namespace core\forms\shop;

use core\entities\shop\Shop;
use core\helpers\product\ShopHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ShopForm extends Model
{
    public $name;
    public $shopMarkup;
    public $internalMarkup;
    public $platform;

    public function __construct(Shop $shop = null, $config = [])
    {
        parent::__construct($config);
        if ($shop) {
            $this->name = $shop->name;
            $this->shopMarkup = $shop->shop_markup;
            $this->internalMarkup = $shop->internal_markup;
            $this->platform = $shop->platform;
        }
    }

    public function rules()
    {
        return [
            [['name', 'shopMarkup', 'platform'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['shopMarkup', 'internalMarkup'], 'number', 'min' => 0],
            [['internalMarkup'], function ($attribute) {
                if ($this->$attribute && $this->shopMarkup > 0) {
                    $this->addError($attribute, "Невозможно одновременно иметь внутреннюю наценку, и наценку в магазине. 
                    Установите \"0\" для наценки в магазине.");
                }
            }],
            [['platform'], 'in', 'range' => array_keys(ShopHelper::platformList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'shopMarkup' => 'Наценка магазина',
            'internalMarkup' => 'Внутреняя наценка',
            'platform' => 'Платформа',
        ];
    }

    public function attributeHints()
    {
        return [
            'internalMarkup' => 'Если наценка уже заложена в цену товара - будет использоваться для рассчёта партнерской награды',
        ];
    }

}