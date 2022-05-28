<?php

namespace core\services\shop;

use core\entities\shop\Coupon;
use core\forms\shop\CouponForm;
use core\repositories\shop\CouponRepository;

class CouponService
{
    private $coupons;

    public function __construct(CouponRepository $coupons)
    {
        $this->coupons = $coupons;
    }

    public function add(CouponForm $form)
    {
        $coupon = Coupon::make($form->shopId, $form->percent, $form->code, $form->comment);
        $this->coupons->save($coupon);

        return $coupon;
    }

    public function edit($id, CouponForm $form)
    {
        $coupon = $this->coupons->get($id);
        $coupon->edit($form->shopId, $form->percent, $form->code, $form->comment);
        $this->coupons->save($coupon);
    }

    public function delete($id)
    {
        $coupon = $this->coupons->get($id);
        $this->coupons->remove($coupon);
    }

}