<?php

namespace core\forms\product;

use core\entities\product\ProductImport;
use yii\base\Model;

class ProductImportForm extends Model
{
    public $ownMiniature;
    public $ownName;
    public $ownDescription;
    public $ownSeo;

    public function __construct(ProductImport $productImport = null, $config = [])
    {
        parent::__construct($config);
        if ($productImport) {
            $this->ownMiniature = $productImport->own_miniature;
            $this->ownName = $productImport->own_name;
            $this->ownDescription = $productImport->own_description;
            $this->ownSeo = $productImport->own_meta;
        }
    }

    public function rules()
    {
        return [
            [['ownMiniature', 'ownName', 'ownDescription', 'ownSeo'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ownMiniature' => 'Блокировка миниатюры',
            'ownName' => 'Блокировка имени',
            'ownDescription' => 'Блокировка описания',
            'ownSeo' => 'Блокировка SEO',
        ];
    }

}