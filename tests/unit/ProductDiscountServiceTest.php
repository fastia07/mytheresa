<?php

class ProductDiscountServiceTest extends \Codeception\Test\Unit
{
    public function testApplyWithDiscountedCategory()
    {
        $product = $this->make(\App\Entity\Product::class, [
            'getCategory' => 'boots',
            'getSku' => '0001',
            'getCost' => 1000
        ]);

        $productDiscountService = new \App\Service\ProductDiscountService();

        $result = $productDiscountService->apply($product);

        $this->assertEquals(700, $result['final'], 'the final price should be 700');
        $this->assertEquals('30%', $result['discount_percentage'], '30% discount for boots category');
        $this->assertEquals('EUR', $result['currency'], 'the currency should be in EUR');
        $this->assertEquals(1000, $result['original'], 'Initial price is 1000');
    }

    public function testApplyWithNonDiscountedCategory()
    {
        $product = $this->make(\App\Entity\Product::class, [
            'getCategory' => 'men',
            'getSku' => '0001',
            'getCost' => 1000
        ]);

        $productDiscountService = new \App\Service\ProductDiscountService();

        $result = $productDiscountService->apply($product);

        $this->assertEquals(1000, $result['original'], 'Initial price is 1000');
        $this->assertEquals(1000, $result['final'], 'the final price should be 1000');
        $this->assertNull($result['discount_percentage'], 'Discount should be null');
        $this->assertEquals('EUR', $result['currency'], 'the currency should be in EUR');
    }

    public function testApplyWithNonDiscountedSku()
    {
        $product = $this->make(\App\Entity\Product::class, [
            'getCategory' => 'women',
            'getSku' => '000001',
            'getCost' => 1000
        ]);

        $productDiscountService = new \App\Service\ProductDiscountService();

        $result = $productDiscountService->apply($product);

        $this->assertEquals(1000, $result['original'], 'Initial price is 1000');
        $this->assertEquals(1000, $result['final'], 'the final price should be 1000');
        $this->assertNull($result['discount_percentage'], 'Discount should be null');
        $this->assertEquals('EUR', $result['currency'], 'the currency should be in EUR');
    }

    public function testApplyWithDiscountedSku()
    {
        $product = $this->make(\App\Entity\Product::class, [
            'getCategory' => 'men',
            'getSku' => '000003',
            'getCost' => 1000
        ]);

        $productDiscountService = new \App\Service\ProductDiscountService();

        $result = $productDiscountService->apply($product);

        $this->assertEquals(850, $result['final'], 'the final price should be 700');
        $this->assertEquals('15%', $result['discount_percentage'], '30% discount for boots category');
        $this->assertEquals('EUR', $result['currency'], 'the currency should be in EUR');
        $this->assertEquals(1000, $result['original'], 'Initial price is 1000');
    }

    public function testFindBiggestDiscount()
    {
        $product = $this->make(\App\Entity\Product::class, [
            'getCategory' => 'boots',
            'getSku' => '000003',
            'getCost' => 1000
        ]);

        $productDiscountService = new \App\Service\ProductDiscountService();

        $result = $productDiscountService->apply($product);

        $this->assertEquals(700, $result['final'], 'the final price should be 700');
        $this->assertEquals('30%', $result['discount_percentage'], '30% discount for boots category');
        $this->assertEquals('EUR', $result['currency'], 'the currency should be in EUR');
        $this->assertEquals(1000, $result['original'], 'Initial price is 1000');
    }
}