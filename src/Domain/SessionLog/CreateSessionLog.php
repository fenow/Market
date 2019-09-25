<?php

namespace App\Domain\SessionLog;

use App\Entity\Session;
use App\Entity\SessionLog;
use Doctrine\ORM\EntityManagerInterface;

class CreateSessionLog
{
    /** @var EntityManagerInterface $em */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Session $session, bool $flush = true)
    {
        /** @var string $status */
        $status = $session->getStatus();

        $sessionLog = (new SessionLog())
            ->setSession($session)
            ->setStatus($status)
        ;

        $this->em->persist($sessionLog);

        if (true === $flush) {
            $this->em->flush();
        }
    }
}
