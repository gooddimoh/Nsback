<?php

namespace core\services\shop;

use core\entities\shop\Shop;
use core\forms\shop\LeqshopForm;
use core\forms\shop\ShopForm;
use core\repositories\shop\ShopRepository;

class ShopService
{
    private $shops;

    public function __construct(ShopRepository $shops)
    {
        $this->shops = $shops;
    }

    public function add(ShopForm $form)
    {
        $entity = Shop::make($form->name, $form->shopMarkup, $form->internalMarkup, $form->platform);
        $this->shops->save($entity);

        return $entity;
    }

    public function edit($id, ShopForm $form)
    {
        $shop = $this->shops->get($id);
        $shop->edit($form->name, $form->shopMarkup, $form->internalMarkup);
        $this->shops->save($shop);
    }

    public function setLeqshop($id, LeqshopForm $form)
    {
        $shop = $this->shops->get($id);
        $f = $form;
        $shop->leqshop ? $shop->editLeqshop($f->domain, $f->apiKeyPublic, $f->apiKeyPrivate, $f->productKey, $f->createOrderKey, $f->userToken, $f->userEmail) :
            $shop->setLeqshop($f->domain, $f->apiKeyPublic, $f->apiKeyPrivate, $f->productKey, $f->createOrderKey, $f->userToken, $f->userEmail);

        $this->shops->save($shop);
    }

    public function delete($id)
    {
        $entity = $this->shops->get($id);
        $this->shops->remove($entity);
    }

}