<?php

Namespace App\Domain\SessionLog;

use App\Entity\Session;
use App\Entity\SessionLog;
use Doctrine\ORM\EntityManagerInterface;

class CreateSessionLog {

    /** @var EntityManagerInterface $em */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Session $session, bool $flush = true) {
        $sessionLog = (new SessionLog())
            ->setSession($session)
            ->setStatus($session->getStatus())
        ;

        $this->em->persist($sessionLog);

        if(true === $flush) {
            $this->em->flush();
        }
    }
}