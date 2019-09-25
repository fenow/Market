<?php


namespace App\Domain\Exchange\Bittrex;

use App\Domain\Exchange\Interfaces\ExchangeAuthenticateInterface;

class BittrexAuthenticate implements ExchangeAuthenticateInterface
{
    /** @var string $apiKey */
    private $apiKey;

    /** @var string $apiSecret */
    private $apiSecret;

    /***
     * BittrexAuthenticate constructor.
     */
    public function __construct()
    {
        $this->apiKey = $_ENV['BITTREX_API_KEY'];
        $this->apiSecret = $_ENV['BITTREX_API_SECRET'];
    }

    /**
     * @param string $url
     * @param array $params
     * @return string
     */
    public function generateSign(string $url, array $params = []): string
    {
        if(is_array($params) && count($params) > 0) {
            $url .= '?' . http_build_query($params);
        }

        $sign = hash_hmac('sha512', $url, $this->apiSecret);
        return $sign;
    }

    /***
     * @return mixed|string
     */
    public function getApiKey() {
        return $this->apiKey;
    }

}