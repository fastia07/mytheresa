<?php

namespace App\Discounts;

use App\Entity\Product;

class DiscountSkus implements DiscountInterface
{
    const skus = [
        '000003' => 15
    ];

    public $fields = [
        'final' => 0,
        'discount_percentage' => null,
    ];

    public function calculate(Product $product):array
    {
        if (array_key_exists($product->getSku(), self::skus)) {
            $discountValue = ceil((self::skus[$product->getSku()] / 100) * $product->getCost());

            $this->fields['final'] = $product->getCost() - $discountValue;
            $this->fields['discount_percentage'] = self::skus[$product->getSku()]. '%';
        }

        return array_filter($this->fields);
    }
}