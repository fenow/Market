<?php

Namespace App\Domain\Session;

use App\Domain\SessionLog\CreateSessionLog;
use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;

class CreateSession
{
    /** @var EntityManagerInterface $em */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(string $market, string $pair, float $price, bool $flush = true) {
        $session = (new Session())
            ->setMarket($market)
            ->setPair($pair)
            ->setPriceWatched($price)
            ->setWatchedAt(new \DateTime())
        ;

        $this->em->persist($session);

        if(true === $flush) {
            $this->em->flush();
        }
    }
}
