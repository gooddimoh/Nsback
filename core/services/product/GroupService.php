<?php

namespace core\services\product;

use core\entities\product\Group;
use core\forms\product\GroupForm;
use core\lib\slug\SlugCreator;
use core\repositories\product\GroupRepository;

class GroupService
{
    private $groups;

    public function __construct(GroupRepository $groups)
    {
        $this->groups = $groups;
    }

    public function add(GroupForm $form)
    {
        $slug = $this->formatSlug($form->name, $form->slug);

        $entity = Group::make($form->categoryId, $form->name, $slug);
        $entity->changeSeoParams($form->seoTitle, $form->seoKeywords, $form->seoDescription);
        $this->groups->save($entity);

        return $entity;
    }

    public function edit($id, GroupForm $form)
    {
        $group = $this->groups->get($id);

        $slug = $form->slug !== $group->slug ? $this->formatSlug("{$group->category->name} - {$form->name}", $form->slug) : $group->slug;

        $group->changeSeoParams($form->seoTitle, $form->seoKeywords, $form->seoDescription);
        $group->edit($form->categoryId, $form->name, $slug);
        $this->groups->save($group);
    }

    public function delete($id)
    {
        $entity = $this->groups->get($id);
        $this->groups->remove($entity);
    }

    protected function formatSlug($name, $slug)
    {
        $slugCreator = new SlugCreator($this->groups);
        return $slugCreator->formatSlug($name, $slug);
    }
}