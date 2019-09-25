<?php


namespace App\Domain\Exchange\Bittrex;


use App\Domain\Api\AbstractApiCall;
use App\Domain\Api\Enum\ApiInputEnum;
use App\Domain\Api\Exceptions\ApiError;
use App\Domain\Api\Exceptions\ApiUrlMissing;
use App\Domain\Api\Exceptions\ApiMethodMissing;
use App\Domain\Exchange\Interfaces\ExchangeGetTickerInterface;
use App\Domain\Exchange\Models\Ticker;


class BittrexExchangeGetTicker extends AbstractApiCall implements ExchangeGetTickerInterface
{
    protected $method = 'GET';
    protected $url = 'https://api.bittrex.com/api/v1.1/public/getticker';

    /***
     * @param string $pair
     * @return Ticker
     * @throws ApiError
     * @throws ApiMethodMissing
     * @throws ApiUrlMissing
     */
    public function getTicker(string $pair): Ticker
    {
        $content = $this->call(['query'=>['market'=>$pair]], ApiInputEnum::JSON);

        if(isset($content->success) && true === $content->success && isset($content->result)) {
            return new Ticker($content->result->Bid, $content->result->Ask, $content->result->Last);
        }

        throw new ApiError(isset($content->message) ? $content->message : 'No result founded');
    }
}
