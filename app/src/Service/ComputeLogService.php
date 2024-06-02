<?php

namespace App\Service;

use App\DependencyInjection\Traits\EntityManagerInterfaceInjectionTrait;
use App\DTO\ComputeLogDTO;
use App\Entity\ComputeLog;
use App\Entity\Rate;
use DateTime;
use DateTimeZone;

class ComputeLogService
{
    use EntityManagerInterfaceInjectionTrait;

    /**
     * @param Rate  $rate
     * @param float $sum
     *
     * @return float
     */
    public function convert(Rate $rate, float $sum): float
    {
        return $sum * $rate->getValue();
    }

    /**
     * @param ComputeLogDTO $logDTO
     */
    public function createFromDTO(ComputeLogDTO $logDTO): void
    {
        //Здесь спорный момент, таймзоны нужно брать в зависимости от того где находится пользователь.
        //Но т.к. у нас нет пользователей, то выбран обычный вариант
        $date = (new DateTime())->setTimezone(new DateTimeZone('Europe/Moscow'));

        $log = (new ComputeLog())
            ->setDate($date)
            ->setRate($logDTO->getRate())
            ->setSum($logDTO->getSum())
            ->setResult($this->convert($logDTO->getRate(), $logDTO->getSum()))
        ;

        $this->getEntityManager()->persist($log);
        $this->getEntityManager()->flush();
    }

    /**
     * @return mixed
     */
    public function getComputeLogs(): mixed
    {
        $logs = $this->getEntityManager()
            ->getRepository(ComputeLog::class)
            ->createQueryBuilder('cl')
            ->addOrderBy("cl.date", 'DESC')
            ->setMaxResults(5)
        ;

        return $logs->getQuery()->getResult();
    }
}