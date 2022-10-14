<?php

class ProductEntityTest extends \Codeception\Test\Unit
{
    public function testProductAttributesAssert()
    {
        $product = new \App\Entity\Product();

        $product->setSku('00003');
        $this->assertEquals('00003', '00003', 'Sku is not same');

        $product->setName('test test');
        $this->assertEquals('test test', $product->getName(), 'Name is not same');

        $product->setCategory('test');
        $this->assertEquals('test', $product->getCategory(), 'Category is not same');

        $product->setCost(100);
        $this->assertEquals(100, $product->getCost(), 'Cost of the product is not same');
    }
}