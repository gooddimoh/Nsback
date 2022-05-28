<?php

namespace core\forms\product;

use core\entities\product\ProductMeta;
use yii\base\Model;

class ProductMetaForm extends Model
{
    public $title;
    public $description;
    public $keywords;

    public $disableImportChange;

    public function __construct(ProductMeta $seo = null, $config = [])
    {
        parent::__construct($config);
        if ($seo) {
            $this->title = $seo->title;
            $this->description = $seo->description;
            $this->keywords = $seo->keywords;
            $this->disableImportChange = $seo->product->productImport->own_meta ?? false;
        }
    }

    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 150],
            [['keywords'], 'string'],
            [['disableImportChange'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'disableImportChange' => 'Запретить изменять информацию провайдером',
        ];
    }

    public function attributeHints()
    {
        return [
            'description' => 'Рекомендуемый размер описания от 50 до 160 символов',
            'disableImportChange' => 'При обновлении информации об товаре SEO обновляться не будет',
        ];
    }


}