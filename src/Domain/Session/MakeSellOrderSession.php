<?php


namespace App\Domain\Session;


use App\Domain\Exchange\Interfaces\ExchangeGetTickerInterface;
use App\Domain\Exchange\Interfaces\ExchangeMakeSellOrderInterface;
use App\Domain\Session\Interfaces\UpdateSessionWithExchangeOrderInterface;
use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;

class MakeSellOrderSession implements UpdateSessionWithExchangeOrderInterface
{
    /** @var ExchangeGetTickerInterface $exchangeGetTicker */
    protected $exchangeGetTicker;

    /** @var ExchangeMakeSellOrderInterface $exchangeMakeSellOrder */
    protected $exchangeMakeSellOrder;

    /** @var EntityManagerInterface $em */
    protected $em;

    public function __construct(
        ExchangeGetTickerInterface $exchangeGetTicker,
        ExchangeMakeSellOrderInterface $exchangeMakeSellOrder,
        EntityManagerInterface $em)
    {
        $this->exchangeGetTicker = $exchangeGetTicker;
        $this->exchangeMakeSellOrder = $exchangeMakeSellOrder;
        $this->em = $em;
    }

    /**
     * @param Session $session
     * @return bool
     */
    public function execute(Session $session): bool {
        $ticker = $this->exchangeGetTicker->getTicker($session->getPair());

        if(self::doIPlaceAnOrder($session->getPriceBuyed(), $ticker->getLast())) {
            $uuid = $this->exchangeMakeSellOrder->makeSellOrder($session, $session->getQuantityBuyed(), $ticker->getLast());
            $this->updateSessionWithExchangeOrder($session, $uuid);

            return true;
        }

        return false;
    }

    private static function doIPlaceAnOrder(float $buyedPrice, float $actualPrice): bool {
        $percent = ($actualPrice / $buyedPrice - 1) * 100;

        return $percent >= $_ENV['MIN_GAIN_PERCENT_TO_SELL'] || $percent < $_ENV['MAX_LOSE_PERCENT_TO_SELL'];
    }

    function updateSessionWithExchangeOrder(Session $session, string $orderUuid): void
    {
        $this->em->persist($session
            ->setStatus(SessionStatusEnum::Selling)
            ->setMarketBuyOrderId($orderUuid)
        );

        $this->em->flush();
    }
}