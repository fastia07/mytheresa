<?php

class DiscountSkusTest extends \Codeception\Test\Unit
{
    public function testCalculate()
    {
        $product = $this->make(\App\Entity\Product::class, [
            'getSku' => '000003',
            'getCost' => 1000
        ]);

        $discountSku = new \App\Discounts\DiscountSkus();

        $result = $discountSku->calculate($product);

        $this->assertEquals(850, $result['final'], 'the final price should 850');
        $this->assertEquals('15%', $result['discount_percentage'], '15% discount for boots category');
    }
}