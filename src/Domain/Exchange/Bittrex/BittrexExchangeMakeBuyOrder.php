<?php

namespace App\Domain\Exchange\Bittrex;

use App\Domain\Api\AbstractApiCallAuthenticated;
use App\Domain\Api\Enum\ApiInputEnum;
use App\Domain\Api\Exceptions\ApiEchangeAuthenticateMissing;
use App\Domain\Api\Exceptions\ApiError;
use App\Domain\Api\Exceptions\ApiMethodMissing;
use App\Domain\Api\Exceptions\ApiUrlMissing;
use App\Domain\Exchange\Bittrex\Traits\SetExchangeAuthenticateTrait;
use App\Domain\Exchange\Interfaces\ExchangeMakeBuyOrderInterface;
use App\Entity\Session;

class BittrexExchangeMakeBuyOrder extends AbstractApiCallAuthenticated implements ExchangeMakeBuyOrderInterface
{
    use SetExchangeAuthenticateTrait;

    protected $method = 'GET';
    protected $url = 'https://api.bittrex.com/api/v1.1/market/buylimit';

    /**
     * @param Session $session
     * @param float   $quantity
     * @param float   $rate
     *
     * @return string
     *
     * @throws ApiEchangeAuthenticateMissing
     * @throws ApiError
     * @throws ApiMethodMissing
     * @throws ApiUrlMissing
     */
    public function makeBuyOrder(Session $session, float $quantity, float $rate): string
    {
        $content = $this->call(['query' => [
            'market' => $session->getPair(),
            'quantity' => $quantity,
            'rate' => $rate,
        ]], ApiInputEnum::JSON);

        if (isset($content->success) && true === $content->success && isset($content->result)) {
            return $content->result->uuid;
        }

        if (isset($content->message) && 'MIN_TRADE_REQUIREMENT_NOT_MET' === $content->message) {
            return '';
        }

        throw new ApiError(isset($content->message) ? $content->message : sprintf('%s - Buy order operation failed !', $session->getMarket()));
    }
}
