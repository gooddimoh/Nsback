<?php

namespace core\services\product\property;

use core\entities\product\property\Property;
use core\forms\product\property\PropertyForm;
use core\forms\product\property\PropertyExternalIdForm;
use core\repositories\product\property\PropertyRepository;

class PropertyService
{
    private PropertyRepository $properties;

    public function __construct(PropertyRepository $properties)
    {
        $this->properties = $properties;
    }

    public function add(PropertyForm $form)
    {
        $entity = Property::make($form->categoryId, $form->name, $form->description);
        $this->properties->save($entity);

        return $entity;
    }

    public function edit($id, PropertyForm $form)
    {
        $entity = $this->properties->find($id);
        $entity->edit($form->categoryId, $form->name, $form->description);
        $this->properties->save($entity);
    }

    public function editExternalId($id, PropertyExternalIdForm $form)
    {
        $entity = $this->properties->find($id);
        $entity->setExternalId($form->external_id);
        $this->properties->save($entity);
    }

    public function delete($id)
    {
        $entity = $this->properties->find($id);
        $this->properties->delete($entity);
    }

}