<?php

class WorkerEntityTest extends \Codeception\Test\Unit
{
    public function testWorkerAttributesAssert()
    {
        $worker = new \App\Entity\Worker();

        $worker->setLeaveBalance(10);
        $this->assertEquals(10, $worker->getLeaveBalance(), 'Leave balance not same');

        $worker->setName('test test');
        $this->assertEquals('test test', $worker->getName(), 'Name is not same');
    }
}