<?php

namespace App\Repository;

use App\Entity\ComputeLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComputeLog>
 *
 * @method ComputeLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComputeLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComputeLog[]    findAll()
 * @method ComputeLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComputeLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComputeLog::class);
    }
}
