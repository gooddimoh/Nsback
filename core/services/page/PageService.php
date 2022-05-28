<?php

namespace core\services\page;


use core\entities\content\Page;
use core\forms\content\PageForm;
use core\repositories\content\PageRepository;
use yii\helpers\Inflector;

class PageService
{
    private $pages;

    public function __construct(PageRepository $pages)
    {
        $this->pages = $pages;
    }

    public function add(PageForm $form)
    {
        $slug = Inflector::slug($form->title);
        $entity = Page::make($slug, $form->title, $form->content, $form->seoDescription, $form->seoKeywords);
        $this->pages->save($entity);

        return $entity;
    }

    public function edit($slug, PageForm $form)
    {
        $entity = $this->pages->get($slug);
        $entity->edit($form->title, $form->content, $form->seoDescription, $form->seoKeywords);
        $this->pages->save($entity);
    }

    public function draft($slug)
    {
        $page = $this->pages->get($slug);
        $page->draft();
        $this->pages->save($page);
    }

    public function public($slug)
    {
        $page = $this->pages->get($slug);
        $page->public();
        $this->pages->save($page);
    }

    public function remove($slug)
    {
        $page = $this->pages->get($slug);
        $page->remove();
        $this->pages->save($page);
    }

}