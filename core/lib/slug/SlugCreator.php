<?php

namespace core\lib\slug;

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class SlugCreator
{
    public $repository;

    public function __construct(SluggableRepository $repository)
    {
        $this->repository = $repository;
    }

    public function formatSlug($name, $slug = null)
    {
        $slug = !$slug ? Inflector::slug($name) : "$slug";
        $handledSlug = $slug;

        for ($i = 1; ; $i++) {
            if (!$this->repository->slugExist($handledSlug)) {
                break;
            }

            $handledSlug = "$slug-$i";
        }

        return StringHelper::truncate($handledSlug, 300, null);
    }

}