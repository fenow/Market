<?php


namespace App\Domain\Exchange\Bittrex;


use App\Domain\Api\AbstractApiCallAuthenticated;
use App\Domain\Api\Enum\ApiInputEnum;
use App\Domain\Api\Exceptions\ApiEchangeAuthenticateMissing;
use App\Domain\Api\Exceptions\ApiError;
use App\Domain\Api\Exceptions\ApiMethodMissing;
use App\Domain\Api\Exceptions\ApiUrlMissing;
use App\Domain\Exchange\Bittrex\Traits\SetExchangeAuthenticateTrait;
use App\Domain\Exchange\Enum\ExchangeOrderTypeEnum;
use App\Domain\Exchange\Interfaces\ExchangeGetOrderInterface;
use App\Domain\Exchange\Models\Order;

class BittrexExchangeGetOrder extends AbstractApiCallAuthenticated implements ExchangeGetOrderInterface
{
    use SetExchangeAuthenticateTrait;

    protected $method = 'GET';
    protected $url = 'https://api.bittrex.com/api/v1.1/account/getorder';

    /**
     * @param string $exchangeOrderId
     * @return Order
     * @throws ApiEchangeAuthenticateMissing
     * @throws ApiError
     * @throws ApiMethodMissing
     * @throws ApiUrlMissing
     * @throws \Exception
     */
    public function getOrder(string $exchangeOrderId): Order
    {
        $content = $this->call(['query'=>['uuid'=>$exchangeOrderId]], ApiInputEnum::JSON);

        if(isset($content->success) && true === $content->success && isset($content->result)) {
            $result = $content->result;

            return (new Order())
                ->setOrderUuid($result->OrderUuid)
                ->setPair($result->Exchange)
                ->setType(self::getOrderType($result->Type))
                ->setQuantity($result->Quantity)
                ->setCommissionPaid($result->CommissionPaid)
                ->setPrice($result->Price)
                ->setPricePerUnit($result->PricePerUnit)
                ->setCreatedAt(new \DateTime($result->Opened))
                ->setClosedAt(new \DateTime($result->Closed))
            ;
        }
    }

    /**
     * @param string $type
     * @return string
     */
    private static function getOrderType(string $type) {
        switch($type) {
            case 'LIMIT_BUY':
                return ExchangeOrderTypeEnum::BUY;

            case 'LIMIT_SELL':
                return ExchangeOrderTypeEnum::SELL;

            default:
                return ExchangeOrderTypeEnum::BOTH;
        }
    }
}
