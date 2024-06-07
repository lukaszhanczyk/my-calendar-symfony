<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getByRangeAndUser(int $year, int $month, int $userId): array
    {
        $firstDay = date($year.'-'.$month.'-01');
        $lastDay = date($year.'-'.$month.'-t');
        return $this->createQueryBuilder('e')
            ->andWhere('e.date >= :firstDay')
            ->andWhere('e.date <= :lastDay')
            ->join('e.user', 'u')
            ->andWhere('u.id = :userId')
            ->setParameter('firstDay', $firstDay)
            ->setParameter('lastDay', $lastDay)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function create(Event $event): void
    {
        $this->_em->persist($event);
        $this->_em->flush();
    }

    public function delete(Event $event): void
    {
        $this->_em->remove($event);
        $this->_em->flush();
    }
}