<?php

namespace App\Service;

use App\Entity\HolidayRequest;
use App\Repository\HolidayRequestRepository;
use App\Repository\ManagerRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

final class HolidayRequestService
{
    /**
     * @var WorkerService
     */
    private $workerService;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var HolidayRequestRepository
     */
    private $holidayRequestRepository;
    /**
     * @var ManagerRepository
     */
    private $managerRepository;

    /**
     * @param WorkerService $workerService
     * @param EntityManagerInterface $entityManager
     * @param HolidayRequestRepository $holidayRequestRepository
     */
    public function __construct(
        WorkerService            $workerService,
        EntityManagerInterface   $entityManager,
        HolidayRequestRepository $holidayRequestRepository,
        ManagerRepository        $managerRepository
    )
    {
        $this->workerService = $workerService;
        $this->entityManager = $entityManager;
        $this->holidayRequestRepository = $holidayRequestRepository;
        $this->managerRepository = $managerRepository;
    }

    /**
     * Create Holiday requests by worker
     *
     * @param HolidayRequest $holidayRequest
     * @return HolidayRequest
     * @throws Exception
     */
    public function add(HolidayRequest $holidayRequest): HolidayRequest
    {
        $balance = $this->workerService->findLeaveBalance($holidayRequest->getAuthor()->getId());
        $numberOfDays = date_diff($holidayRequest->getVacationStartDate(), $holidayRequest->getVacationEndDate())->days;

        if (empty($balance) || $balance < $numberOfDays)
            throw new Exception('Dont have sufficient leave balance to apply.');

        $this->entityManager->persist($holidayRequest);
        $this->entityManager->flush();

        return $holidayRequest;
    }

    /**
     * Return list of leaves requests
     *
     * @param string $status
     * @param int|null $workerId
     * @return array
     * @throws Exception
     */
    public function getHolidayRequests(string $status, int $workerId = null): array
    {
        $criteria = ['status' => $status];

        if ($workerId) {
            $criteria['author'] = $workerId;
        }

        $holidayRequests = $this->holidayRequestRepository->findBy($criteria);

        if (!$holidayRequests) {
            throw new Exception('Leave requests not found with your selected filters');
        }

        return $holidayRequests;
    }

    /**
     * Update leave request statuses by manager
     *
     * @param int $holidayRequestId
     * @param int $managerId
     * @param string $status
     * @return HolidayRequest
     * @throws Exception
     */
    public function update(int $holidayRequestId, int $managerId, string $status): HolidayRequest
    {
        $holidayRequest = $this->holidayRequestRepository->find($holidayRequestId);

        if (!$holidayRequest) {
            throw new Exception('No Holiday Request found with ' . $holidayRequestId);
        }

        $manager = $this->managerRepository->find($managerId);

        if (!$manager) {
            throw new Exception('No manager found with manager id ' . $managerId);
        }

        $holidayRequest->setStatus($status);
        $holidayRequest->setResolvedBy($manager);

        $this->entityManager->persist($holidayRequest);
        $this->entityManager->flush();

        if ($holidayRequest->getStatus() == 'approved') {
            $numberOfDays = date_diff($holidayRequest->getVacationStartDate(), $holidayRequest->getVacationEndDate())->days;
            $this->workerService->deductLeaves($holidayRequest->getAuthor()->getId(), $numberOfDays);
        }

        return $holidayRequest;
    }

    /**
     * List all overlapping requests
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getOverlappingRequests(string $startDate, string $endDate): array
    {
        return $this->holidayRequestRepository->fetchOverlappedRequests($startDate, $endDate);
    }
}