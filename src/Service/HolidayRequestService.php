<?php

namespace App\Service;

use App\Entity\HolidayRequest;
use App\Repository\HolidayRequestRepository;
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
     * @param WorkerService $workerService
     * @param EntityManagerInterface $entityManager
     * @param HolidayRequestRepository $holidayRequestRepository
     */
    public function __construct(
        WorkerService            $workerService,
        EntityManagerInterface   $entityManager,
        HolidayRequestRepository $holidayRequestRepository
    )
    {
        $this->workerService = $workerService;
        $this->entityManager = $entityManager;
        $this->holidayRequestRepository = $holidayRequestRepository;
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
        $balance = $this->workerService->findLeaveBalance($holidayRequest->getAuthor());
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

        $holidayRequest->setStatus($status);
        $holidayRequest->setResolvedBy($managerId);

        $this->entityManager->persist($holidayRequest);
        $this->entityManager->flush();

        if ($holidayRequest->getStatus() == 'approved') {
            $numberOfDays = date_diff($holidayRequest->getVacationStartDate(), $holidayRequest->getVacationEndDate())->days;
            $this->workerService->deductLeaves($holidayRequest->getAuthor(), $numberOfDays);
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