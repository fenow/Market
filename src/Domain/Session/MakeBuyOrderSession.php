<?php


namespace App\Domain\Session;


use App\Domain\Exchange\Exceptions\UnknownExchange;
use App\Domain\Exchange\ExchangeHelpers;
use App\Domain\Exchange\Interfaces\ExchangeGetBalanceInterface;
use App\Domain\Exchange\Interfaces\ExchangeGetTickerInterface;
use App\Domain\Exchange\Interfaces\ExchangeMakeBuyOrderInterface;
use App\Domain\Session\Interfaces\UpdateSessionWithExchangeOrderInterface;
use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;

class MakeBuyOrderSession implements UpdateSessionWithExchangeOrderInterface
{
    /** ExchangeGetTickerInterface $exchangeGetTicker */
    protected $exchangeGetTicker;

    /** @var ExchangeGetBalanceInterface $exchangeGetBalance */
    protected $exchangeGetBalance;

    /** @var ExchangeMakeBuyOrderInterface */
    protected $exchangeMakeBuyOrder;

    /** @var EntityManagerInterface $em */
    protected $em;

    public function __construct(
        ExchangeGetTickerInterface $exchangeGetTicker,
        ExchangeGetBalanceInterface $exchangeGetBalance,
        ExchangeMakeBuyOrderInterface $exchangeMakeBuyOrder,
        EntityManagerInterface $em
    ) {
        $this->exchangeGetTicker = $exchangeGetTicker;
        $this->exchangeGetBalance = $exchangeGetBalance;
        $this->exchangeMakeBuyOrder = $exchangeMakeBuyOrder;
        $this->em = $em;
    }

    /**
     * @param Session $session
     * @return bool
     * @throws UnknownExchange
     */
    public function execute(Session $session): bool {
        $balance = $this->exchangeGetBalance->getBalance(
            ExchangeHelpers::getCurrencyByExchange($session->getPair(), $session->getMarket())
        );

        $ticker = $this->exchangeGetTicker->getTicker($session->getPair());
        $price = $ticker->getLast();
        $quantity = self::getQuantity($balance->getAvailable(), $price);

        if($quantity > 0) {
            $uuid = $this->exchangeMakeBuyOrder->makeBuyOrder($session, $quantity, $price);

            if(!empty($uuid)) {
                $this->updateSessionWithExchangeOrder($session, $uuid);
                return true;
            }
        } else {
            $this->em->remove($session);
            $this->em->flush();
        }

        return false;
    }

    private static function getQuantity(float $available, float $price): int {
        $quantity = $available > $_ENV['NB_BTC_BY_TRADE'] ?
            floor($_ENV['NB_BTC_BY_TRADE'] / $price) :
            floor($available / $price);

        return $quantity;
    }

    public function updateSessionWithExchangeOrder(Session $session, string $orderUuid): void
    {
        $this->em->persist($session
            ->setStatus(SessionStatusEnum::Buying)
            ->setMarketBuyOrderId($orderUuid)
        );

        $this->em->flush();
    }
}