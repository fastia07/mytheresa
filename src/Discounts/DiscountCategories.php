<?php

namespace App\Discounts;

use App\Entity\Product;

class DiscountCategories implements DiscountInterface
{
    const categories = [
        'boots' => 30
    ];

    public $fields = [
        'final' => 0,
        'discount_percentage' => null,
    ];
    
    public function calculate(Product $product): array
    {
        if (array_key_exists($product->getCategory(), self::categories)) {
            $discountValue = ceil((self::categories[$product->getCategory()] / 100) * $product->getCost());

            $this->fields['final'] = $product->getCost() - $discountValue;
            $this->fields['discount_percentage'] = self::categories[$product->getCategory()] . '%';
        }

        return array_filter($this->fields);
    }
}