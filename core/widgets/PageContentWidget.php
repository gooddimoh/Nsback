<?php

namespace core\widgets;

use core\entities\content\Page;
use yii\base\Widget;

class PageContentWidget extends Widget
{
    public $page;
    public $errorMessage = "Ошибка при загрузке контента. Пожалуйста, перезагрузите страницу или свяжитесь с поддержкой";

    public function run()
    {
        if ($this->page instanceof Page) {
            return $this->page->content;
        }
        return $this->errorMessage;
    }

}