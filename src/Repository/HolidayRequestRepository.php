<?php

namespace App\Repository;

use App\Entity\HolidayRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HolidayRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method HolidayRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method HolidayRequest[]    findAll()
 * @method HolidayRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HolidayRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HolidayRequest::class);
    }

    public function fetchOverlappedRequests(string $startDate, string $endDate): array
    {
        $qb = $this->createQueryBuilder('holiday_request');
        $qb->andWhere('holiday_request.status = :status');
        $qb->andWhere(':startDate < holiday_request.vacation_end_date');
        $qb->andWhere(':endDate > holiday_request.vacation_start_date');
        $qb->setParameter('startDate', $startDate);
        $qb->setParameter('endDate', $endDate);
        $qb->setParameter('status', 'pending');

        return $qb->getQuery()->getResult();
    }
}
