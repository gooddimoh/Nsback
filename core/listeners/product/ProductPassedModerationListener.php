<?php

namespace core\listeners\product;

use core\entities\product\events\ProductPassedModeration;

class ProductPassedModerationListener
{

    public function handle(ProductPassedModeration $event)
    {
    }

}