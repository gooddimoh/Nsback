<?php

namespace core\lib\raptor;

use Faker\Factory;

trait ProductList
{
    protected static function getRandomiseList($quantity = 150)
    {
        $faker = Factory::create("ru_RU");
        $products = [];

        while ($quantity) {
            $products[] = [
                'id' => $faker->unique()->numberBetween(1, 1000),
                'name' => rtrim($faker->sentence(3), "."),
                'miniature' => $faker->imageUrl(320, 240),
                //'miniature' => Image::get(),
                'description' => $faker->realTextBetween(100, 2500),
                'price' => $faker->numberBetween(1, 1350),
                'minimumOrder' => $faker->numberBetween(1, 3),
                'quantity' => $faker->numberBetween(1, 20000), // 500
                'purchaseCounter' => $faker->numberBetween(1, 110000),
            ];

            $quantity--;
        }

        return $products;
    }

}