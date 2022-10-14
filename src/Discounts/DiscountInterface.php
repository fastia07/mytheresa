<?php

namespace App\Discounts;

use App\Entity\Product;

interface DiscountInterface
{
    public function calculate(Product $product): array;

}