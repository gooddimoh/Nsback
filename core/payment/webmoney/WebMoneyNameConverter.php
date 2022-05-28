<?php

namespace core\payment\webmoney;


use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use yii\helpers\Inflector;

class WebMoneyNameConverter implements NameConverterInterface
{
    public function normalize($propertyName)
    {
        $propertyName = Inflector::camel2id('_');
        $propertyName = strtoupper($propertyName);
        $propertyName = 'LMI_' . $propertyName;

        return $propertyName;
    }

    public function denormalize($propertyName)
    {
        $propertyName = str_replace(['LMI', '_'], ' ', $propertyName);
        $propertyName = trim($propertyName);
        $propertyName = strtolower($propertyName);
        $propertyName = Inflector::camelize($propertyName);
        $propertyName = lcfirst($propertyName);

        return $propertyName;
    }
}