<?php

namespace core\entities\product\property;

trait PropertyTrait
{
    public $properties = [];

    public function isPropertyExists($id)
    {
        foreach ($this->properties as $propertyId) {
            if ($propertyId == $id) {
                return true;
            }
        }
        return false;
    }

    /***
     * @return array|\yii\db\ActiveRecord[]|PropertyCategory[]
     */
    public static function getPropertyCategoryList()
    {
        return PropertyCategory::find()->all();
    }

}