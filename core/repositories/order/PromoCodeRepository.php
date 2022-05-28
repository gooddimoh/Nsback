<?php

namespace core\repositories\order;

use core\entities\order\PromoCode;
use core\repositories\exceptions\NotFoundException;

class PromoCodeRepository
{
    /**
     * @param $id
     * @return PromoCode
     */
    public function get($id)
    {
        return  $this->getBy(['id' => $id]);
    }

    public function getByCode($code)
    {
        return $this->getBy(['code' => $code]);
    }

    /**
     * @param $condition
     * @return PromoCode
     */
    public function getBy($condition)
    {
        if (!$model = PromoCode::findOne($condition)) {
            throw new NotFoundException('Промо-код не найден');
        }
        return $model;
    }

    public function add(PromoCode $model)
    {
        if (!$model->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }
        if (!$model->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function save(PromoCode $model)
    {
        if ($model->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($model->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function delete(PromoCode $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
} 