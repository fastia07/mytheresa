<?php

class ManagerEntityTest extends \Codeception\Test\Unit
{
    public function testManagerAttributesAssert()
    {
        $manager = new \App\Entity\Manager();

        $manager->setName('Mr.manager');
        $this->assertEquals('Mr.manager', $manager->getName(), 'Name is not same');
    }
}