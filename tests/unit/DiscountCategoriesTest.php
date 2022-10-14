<?php

class DiscountCategoriesTest extends \Codeception\Test\Unit
{
    public function testCalculate()
    {
        $product = $this->make(\App\Entity\Product::class, [
            'getCategory' => 'boots',
            'getCost' => 1000
        ]);

        $discountCategory = new \App\Discounts\DiscountCategories();

        $result = $discountCategory->calculate($product);

        $this->assertEquals(700, $result['final'], 'the final price should be 700');
        $this->assertEquals('30%', $result['discount_percentage'], '30% discount for boots category');
    }
}