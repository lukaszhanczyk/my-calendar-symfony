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