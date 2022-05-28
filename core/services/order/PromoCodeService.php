<?php

namespace core\services\order;

use core\repositories\order\PromoCodeRepository;
use core\entities\order\PromoCode;
use core\forms\order\promo\PromoCodeForm;
use core\forms\order\promo\PromoCodeBulkForm;

class PromoCodeService
{
    private $promoCodes;

    public function __construct(PromoCodeRepository $promoCodes)
    {
        $this->promoCodes = $promoCodes;
    }

    public function add(PromoCodeForm $form)
    {
        $entity = PromoCode::make($form->code, $form->percent, $form->comment, $form->activationLimit);
        $this->promoCodes->add($entity);

        return $entity;
    }

    public function addBulk(PromoCodeBulkForm $form)
    {
        $codes = explode("\n", $form->codes);
        $result = [];

        foreach ($codes as $code) {
            $promoCode = PromoCode::make(trim($code), $form->percent, $form->comment, $form->activationLimit);
            $this->promoCodes->add($promoCode);
            $result[] = $promoCode;
        }

        return $result;
    }

    public function activate($id)
    {
        $entity = $this->promoCodes->get($id);
        if ($entity->isActive()) {
            throw new \DomainException('Промо-код уже активен');
        }
        $entity->activate();
        $this->promoCodes->save($entity);
    }

    public function inactivate($id)
    {
        $entity = $this->promoCodes->get($id);
        if ($entity->isInactive()) {
            throw new \DomainException('Промо-код отключён');
        }
        $entity->inactivate();
        $this->promoCodes->save($entity);
    }

    public function delete($id)
    {
        $entity = $this->promoCodes->get($id);
        $entity->remove();
        $this->promoCodes->save($entity);
    }

}