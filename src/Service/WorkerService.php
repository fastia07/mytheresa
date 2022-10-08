<?php

namespace App\Service;

use App\Entity\Worker;
use App\Repository\WorkerRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

final class WorkerService
{
    /**
     * @var WorkerRepository
     */
    private $workerRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param WorkerRepository $workerRepository
     */
    public function __construct(
        WorkerRepository       $workerRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->workerRepository = $workerRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Return leave balance of workers
     *
     * @param int $workerId
     * @return int
     * @throws Exception
     */
    public function findLeaveBalance(int $workerId): int
    {
        $worker = $this->workerRepository->find($workerId);

        if (!$worker) {
            throw new Exception('No worker found for worker ID:' . $workerId);
        }

        return $worker->getLeaveBalance();
    }

    /**
     * Find worker by worker id
     *
     * @param int $workerId
     * @return Worker
     * @throws Exception
     */
    public function findWorker(int $workerId): Worker
    {
        $worker = $this->workerRepository->find($workerId);

        if (!$worker) {
            throw new Exception('No worker found for worker ID:' . $workerId);
        }

        return $worker;
    }

    /**
     * Adjust the worker leaves
     * 
     * @param int $workerId
     * @param int $totalLeavesApproved
     * @return Worker
     * @throws Exception
     */
    public function deductLeaves(int $workerId, int $totalLeavesApproved): Worker
    {
        $worker = $this->workerRepository->find($workerId);

        if (!$worker) {
            throw new Exception('No worker found for worker ID:' . $workerId);
        }

        $worker->setLeaveBalance(($worker->getLeaveBalance() - $totalLeavesApproved));

        $this->entityManager->persist($worker);
        $this->entityManager->flush();

        return $worker;
    }

}