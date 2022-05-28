<?php

namespace core\entities\product\dto;

class ProductFromProvider
{
    public $id;
    public $name;
    public $miniature;
    public $description;
    public $price;
    public $minimumOrder;
    public $quantity;
    public $purchaseCounter;

    private $meta;
    private $properties = [];

    public function __construct($id, $name, $miniature, $description, $price, $minimumOrder, $quantity, $purchaseCounter)
    {
        $this->id = $id;
        $this->name = strip_tags($name);
        $this->miniature = $miniature;
        $this->description = $description;
        $this->price = $price;
        $this->minimumOrder = $minimumOrder;
        $this->quantity = $quantity;
        $this->purchaseCounter = $purchaseCounter;
    }

    /**
     * @return Meta|null
     */
    public function getMeta(): ?Meta
    {
        return $this->meta;
    }

    public function setMeta(Meta $meta)
    {
        $this->meta = $meta;
    }

    public function addProperty($value)
    {
        $this->properties[] = new Property($value);
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function getPropertiesValue()
    {
        if (!$this->hasProperties()) {
            return [];
        }

        return array_map(function (Property $p) {
            return $p->getValue();
        }, $this->properties);
    }

    public function hasProperties()
    {
        return !empty($this->properties);
    }

}