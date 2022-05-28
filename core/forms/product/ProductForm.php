<?php

namespace core\forms\product;

use core\entities\product\Category;
use core\entities\product\Product;
use core\entities\Product\Property\Property;
use core\entities\product\property\PropertyTrait;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class ProductForm extends Model
{
    public $groupId;
    public $name;
    public $slug;
    public $miniature;
    public $description;
    public $rules;
    public $price;
    public $minimumOrder;
    public $quantity;
    public $properties = [];

    private $product;

    use PropertyTrait;

    public function __construct(Product $product = null, $config = [])
    {
        parent::__construct($config);
        if ($product) {
            $this->product = $product;

            $this->groupId = $product->group_id;
            $this->name = $product->name;
            $this->slug = $product->slug;
            $this->description = $product->description;
            $this->rules = $product->rules;
            $this->price = $product->price;
            $this->minimumOrder = $product->minimum_order;
            $this->quantity = $product->quantity;
            $this->properties = $product->properties ? ArrayHelper::map($product->properties, 'property_id', 'property_id') : [];
        }
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->miniature = UploadedFile::getInstance($this, 'miniature');
            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            [['groupId', 'name', 'price', 'minimumOrder', 'quantity'], 'required'],
            [['slug'], 'string', 'max' => 492],
            [['miniature'], 'image', 'maxSize' => 1024 * 1024 * 5],
            [['description', 'rules'], 'string'],
            [['price',], 'number', 'min' => 0.001],
            [['minimumOrder'], 'integer', 'min' => 1],
            [['quantity'], 'integer', 'min' => 0],
            [['properties'], 'each', 'rule' => ['exist', 'targetClass' => Property::class, 'targetAttribute' => 'id']]
        ];
    }

    public function attributeHints()
    {
        return [
            'slug' => 'Используется в URL. Например: https://domain.com/products/view/<b>steam-packages</b>.  
                Если оставить поле незаполненным - сгенерируется автоматически',
        ];
    }

    public function attributeLabels()
    {
        return [
            'groupId' => 'Группа',
            'name' => 'Название',
            'slug' => 'URL',
            'rules' => 'Правила',
            'miniature' => 'Миниатюра',
            'description' => 'Описание',
            'price' => 'Цена',
            'minimumOrder' => 'Минимальный заказ',
            'quantity' => 'Количество',
            'properties' => 'Свойства',
        ];
    }

    public function getProduct()
    {
        return $this->product;
    }


    public static function getGroups()
    {
        $list = [];

        /** @var $category Category */
        foreach (Category::find()->each() as $category) {
            foreach ($category->groups as $group) {
                $list[$category->name][$group->id] = $group->name;
            }
        }

        return $list;
    }


}