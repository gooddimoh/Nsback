<?php

namespace core\services\product;

use core\entities\product\Category;
use core\forms\product\CategoryForm;
use core\lib\fileManager\FileSaver;
use core\lib\slug\SlugCreator;
use core\repositories\product\CategoryRepository;

class CategoryService
{
    private $categories;
    private $fileManager;

    public function __construct(CategoryRepository $repository)
    {
        $this->categories = $repository;
        $this->fileManager = new FileSaver(\Yii::$app->params['media.categoriesPath']); // TODO: Временно до находки решения
    }

    public function add(CategoryForm $form)
    {
        $slug = $this->formatSlug($form->name, $form->slug);

        $category = Category::make($form->name, $slug);
        if ($form->icon) {
            $category->setIcon($this->fileManager->storeFile($form->icon));
        }
        $category->changeMeta($form->seoTitle, $form->seoKeywords, $form->seoDescription);

        $this->categories->save($category);

        return $category;
    }

    public function edit($id, CategoryForm $form)
    {
        $category = $this->categories->get($id);

        $slug = $form->slug !== $category->slug ? $this->formatSlug($form->name, $form->slug) : $category->slug;
        $category->edit($form->name, $slug);
        $category->changeMeta($form->seoTitle, $form->seoKeywords, $form->seoDescription);
        if ($form->icon) {
            $category->setIcon($this->fileManager->storeFile($form->icon));
        }

        $this->categories->save($category);
    }

    protected function formatSlug($name, $slug)
    {
        $slugCreator = new SlugCreator($this->categories);
        return $slugCreator->formatSlug($name, $slug);
    }

    public function delete($id)
    {
        $entity = $this->categories->get($id);
        $entity->clearIcon();
        $this->categories->remove($entity);
    }
}