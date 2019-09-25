<?php


namespace App\Domain\Exchange\Bittrex;

use App\Domain\Api\AbstractApiCallAuthenticated;
use App\Domain\Api\Enum\ApiInputEnum;
use App\Domain\Api\Exceptions\ApiEchangeAuthenticateMissing;
use App\Domain\Api\Exceptions\ApiError;
use App\Domain\Api\Exceptions\ApiMethodMissing;
use App\Domain\Api\Exceptions\ApiUrlMissing;
use App\Domain\Exchange\Bittrex\Traits\SetExchangeAuthenticateTrait;
use App\Domain\Exchange\Interfaces\ExchangeMakeSellOrderInterface;
use App\Entity\Session;

class BittrexExchangeMakeSellOrder extends AbstractApiCallAuthenticated implements ExchangeMakeSellOrderInterface
{
    use SetExchangeAuthenticateTrait;

    protected $method = 'GET';
    protected $url = 'https://api.bittrex.com/api/v1.1/market/selllimit';

    /**
     * @param Session $session
     * @param float $quantity
     * @param float $rate
     * @return string
     * @throws ApiEchangeAuthenticateMissing
     * @throws ApiError
     * @throws ApiMethodMissing
     * @throws ApiUrlMissing
     */
    public function makeSellOrder(Session $session, float $quantity, float $rate): string {
        $content = $this->call(['query'=>[
            'market' => $session->getPair(),
            'quantity' => $quantity,
            'rate' => $rate
        ]], ApiInputEnum::JSON);

        if(isset($content->success) && true === $content->success && isset($content->result)) {
            return $content->result->uuid;
        }

        throw new ApiError(isset($content->message) ? $content->message : sprintf('%s - Sell order operation failed !', $session->getMarket()));
    }
}
