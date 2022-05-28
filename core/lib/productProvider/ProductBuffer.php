<?php

namespace core\lib\productProvider;

class ProductBuffer
{
    const SHOP_LIMIT = 3; // Чтобы не выходить за лимит памяти. Более тонко: освобождение с учетом занимаемой памяти.

    private array $shops = [];

    public function getOrAdd($id, \Closure $callable)
    {
        if (!$this->isset($id)) {
            $this->add($id, call_user_func($callable));
        }

        return $this->get($id);
    }

    public function isset($id)
    {
        return isset($this->shops[$id]);
    }

    public function add($id, $product)
    {
        if (count($this->shops) >= self::SHOP_LIMIT) {
            $this->removeFirst();
        }

        $this->shops[$id] = $product;
    }

    protected function removeFirst()
    {
        $index = array_key_first($this->shops);
        unset($this->shops[$index]);
    }

    public function get($id)
    {
        return $this->isset($id) ? $this->shops[$id] : false;
    }

}