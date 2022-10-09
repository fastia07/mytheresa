<?php

class HolidayRequestServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;


    /** @var \App\Service\HolidayRequestService $holidayService */
    private $holidayService;

    protected function _before()
    {
        $worker = $this->make(\App\Entity\Worker::class, [
            'getLeaveBalance' => 30,
        ]);

        $workerRepository = $this->make(\App\Repository\WorkerRepository::class, [
            'find' => $worker
        ]);

        $entityManagerInterface = $this->makeEmpty(\Doctrine\ORM\EntityManagerInterface::class, [
            'persist' => $worker,
            'flush' => true
        ]);

        $workerService = new \App\Service\WorkerService($workerRepository, $entityManagerInterface);

        $entityManagerInterface = $this->makeEmpty(\Doctrine\ORM\EntityManagerInterface::class, [
            'persist' => $worker,
            'flush' => true
        ]);

        $holidayRequestRepository = $this->make(\App\Repository\HolidayRequestRepository::class, [
            'fetchOverlappedRequests' => function () {
                return [new \App\Entity\HolidayRequest()];
            },
            'findBy' => function () {
                return [new \App\Entity\HolidayRequest()];
            }
        ]);

        $manager = $this->make(\App\Entity\Manager::class, [
            'name' => 'Mr.Test Manager',
        ]);

        $managerRepository = $this->make(\App\Repository\ManagerRepository::class, [
            'find' => $manager
        ]);

        $this->holidayService = new \App\Service\HolidayRequestService(
            $workerService,
            $entityManagerInterface,
            $holidayRequestRepository,
            $managerRepository
        );
    }

    // tests
    public function testGetOverlappingRequests()
    {
        $holidayRequests = $this->holidayService->getOverlappingRequests('2022-10-10', '2022-12-13');
        $this->assertIsArray($holidayRequests, 'Doesnt return list of holiday requests');
    }

    // tests
    public function testGetHolidayRequests()
    {
        /** @var \App\Entity\HolidayRequest $holidayRequests */
        $holidayRequests = $this->holidayService->getHolidayRequests('pending');
        $this->assertIsArray($holidayRequests, 'Not return any holiday requests');
    }

    // tests
    public function testAddHolidayRequests()
    {
        $worker = $this->make(\App\Entity\Worker::class, [
            'getId' => 1,
            'name' => 'Test worker',
            'leave_balance' => 30
        ]);

        $holidayRequest = $this->make(\App\Entity\HolidayRequest::class, [
            'getAuthor' => $worker,
            'getVacationStartDate' => new DateTime("2022-10-10 18:15:56"),
            'getVacationEndDate' => new DateTime("2022-10-12 18:15:56")
        ]);


        $result = $this->holidayService->add($holidayRequest);

        $this->assertEquals($holidayRequest->getId(), $result->getId(), 'holiday request not save');
    }
}