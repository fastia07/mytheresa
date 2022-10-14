<?php

namespace App\Service;

use App\Discounts\DiscountCategories;
use App\Discounts\DiscountSkus;
use App\Entity\Product;

final class ProductDiscountService
{
    /**
     * Apply discount on category and skus.
     * @param Product $product
     * @return array
     */
    public function apply(Product $product): array
    {
        $result = [
            'original' => $product->getCost(),
            'currency' => 'EUR',
            'final' => $product->getCost(),
            'discount_percentage' => null
        ];

        $discountCategories = new DiscountCategories();
        $discountSkus = new DiscountSkus();

        $discountCategory = $discountCategories->calculate($product);
        $discountSku = $discountSkus->calculate($product);

        if (empty($discountCategory) && empty($discountSku)) {
            return $result;
        }

        if (empty($discountCategory) && !empty($discountSku)) {
            $result['final'] = $discountSku['final'];
            $result['discount_percentage'] = $discountSku['discount_percentage'];
        }

        if (empty($discountSku) && !empty($discountCategory)) {
            $result['final'] = $discountCategory['final'];
            $result['discount_percentage'] = $discountCategory['discount_percentage'];
        }

        // Apply the biggest discount
        if (!empty($discountSku) && !empty($discountCategory)) {
            $result['final'] = $discountSku['final'] < $discountCategory['final'] ? $discountSku['final'] : $discountCategory['final'];
            $result['discount_percentage'] = $discountSku['final'] < $discountCategory['final'] ? $discountSku['discount_percentage'] : $discountCategory['discount_percentage'];
        }

        return $result;
    }
}