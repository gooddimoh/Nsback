<?php

namespace core\services\product\property;

use core\entities\product\property\PropertyCategory;
use core\forms\product\property\PropertyCategoryForm;
use core\forms\product\property\PropertyExternalIdForm;
use core\repositories\product\property\PropertyCategoryRepository;

class PropertyCategoryService
{
    private PropertyCategoryRepository $categories;

    public function __construct(PropertyCategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function add(PropertyCategoryForm $form): PropertyCategory
    {
        $entity = PropertyCategory::make($form->name, $form->description);
        $this->categories->save($entity);

        return $entity;
    }

    public function edit($id, PropertyCategoryForm $form)
    {
        $entity = $this->categories->find($id);
        $entity->edit($form->name, $form->description);
        $this->categories->save($entity);
    }

    public function editExternalId($id, PropertyExternalIdForm $form)
    {
        $entity = $this->categories->find($id);
        $entity->setExternalId($form->external_id);
        $this->categories->save($entity);
    }



}