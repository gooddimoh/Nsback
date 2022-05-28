<?php

namespace core\repositories\product;

use core\dispatchers\EventDispatcher;
use core\entities\product\RulesTemplate;
use core\repositories\exceptions\NotFoundException;

class RulesTemplateRepository
{
    private EventDispatcher $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param $id
     * @return RulesTemplate
     */
    public function find($id)
    {
        if (!$model = RulesTemplate::findOne($id)) {
            throw new NotFoundException('Template is not found');
        }
        return $model;
    }

    public function add(RulesTemplate $model)
    {
        if (!$model->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }
        if (!$model->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function save(RulesTemplate $model)
    {
        if ($model->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($model->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }

        $this->dispatcher->dispatchAll($model->releaseEvents());
    }

    public function delete(RulesTemplate $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
} 