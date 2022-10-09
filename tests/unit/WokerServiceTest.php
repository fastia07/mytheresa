<?php

class WokerServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \App\Entity\Worker $worker
     */
    private $worker;

    /** @var \App\Service\WorkerService $workerService */
    private $workerService;

    private $leaveBalance = 10;

    protected function _before()
    {
        $this->worker = $this->make(\App\Entity\Worker::class, [
            'getLeaveBalance' => $this->leaveBalance,
        ]);

        $workerRepository = $this->make(\App\Repository\WorkerRepository::class, [
            'find' => $this->worker
        ]);

        $entityManagerInterface = $this->makeEmpty(\Doctrine\ORM\EntityManagerInterface::class, [
            'persist' => $this->worker,
            'flush' => true
        ]);

        $this->workerService = new \App\Service\WorkerService($workerRepository, $entityManagerInterface);
    }

    public function testFindLeaveBalance()
    {
        $workerId = 100;
        $balance = $this->workerService->findLeaveBalance($workerId);
        $this->assertEquals($this->leaveBalance, $balance, 'Leave balance are not same');
    }

    public function testFindWorker()
    {
        $workerId = 100;
        $worker = $this->workerService->findWorker($workerId);

        $this->assertEquals($this->worker->getId(), $worker->getId(), 'Worker Id is not same');
    }
}