<?php


namespace App\Domain\Session;

use App\Domain\Exchange\Interfaces\ExchangeGetOrderInterface;
use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;

class SoldSession
{
    /** @var ExchangeGetOrderInterface $exchangeGetOrder */
    protected $exchangeGetOrder;

    /** @var EntityManagerInterface $em */
    protected $em;

    public function __construct(ExchangeGetOrderInterface $exchangeGetOrder, EntityManagerInterface $em)
    {
        $this->exchangeGetOrder = $exchangeGetOrder;
        $this->em = $em;
    }

    /**
     * @param Session $session
     * @return bool
     */
    public function execute(Session $session): bool {
        $order = $this->exchangeGetOrder->getOrder($session->getMarketSellOrderId());

        if($order->getClosedAt()) {
            $session
                ->setStatus(SessionStatusEnum::Sold)
                ->setPriceSold($order->getPricePerUnit())
                ->setSoldAt($order->getClosedAt())
            ;

            $this->em->persist($session);
            $this->em->flush();

            return true;
        }

        return false;
    }
}