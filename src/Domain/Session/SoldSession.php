<?php

namespace App\Domain\Session;

use App\Domain\Exchange\Interfaces\ExchangeGetOrderInterface;
use App\Domain\Session\Interfaces\ExecuteFlow;
use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;

class SoldSession implements ExecuteFlow
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
     *
     * @return bool
     */
    public function execute(Session $session): bool
    {
        /** @var string $orderId */
        $orderId = $session->getMarketSellOrderId();

        $order = $this->exchangeGetOrder->getOrder($orderId);

        if (!is_null($order->getClosedAt())) {
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
