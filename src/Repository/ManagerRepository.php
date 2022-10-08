<?php

namespace App\Repository;

use App\Entity\Manager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Manager|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manager|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manager[]    findAll()
 * @method Manager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManagerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manager::class);
    }
}
