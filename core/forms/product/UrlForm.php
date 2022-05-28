<?php

namespace core\forms\product;

use core\entities\product\Product;
use yii\base\Model;

class UrlForm extends Model
{
    public $slug;

    public function __construct(Product $product, $config = [])
    {
        parent::__construct($config);
        $this->slug = $product->slug;
    }

    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['slug'], 'unique', 'targetClass' => Product::class, 'targetAttribute' => 'slug'],
            [['slug'], 'string', 'max' => 492],
        ];
    }

    public function attributeLabels()
    {
        return [
            'slug' => 'URL',
        ];
    }
    
    public function attributeHints()
    {
    	return [
    		'slug' => 'Используется в URL. Например: https://domain.com/products/view/<b>steam-packages</b>.',
    	];
    }


}