<?php

namespace App\Domain\TradingView\Opportunity;

use App\Domain\Api\AbstractApiCall;
use App\Domain\Api\Enum\ApiInputEnum;
use App\Domain\Exchange\Exceptions\UnknownExchange;
use App\Domain\Exchange\ExchangeHelpers;
use App\Domain\Session\CreateSession;
use App\Domain\Api\Exceptions\ApiError;
use App\Domain\Session\Exceptions\TooManyTradeInProgress;
use App\Domain\TradingView\Enum\OpportunityEnum;
use App\Repository\SessionRepository;
use Symfony\Component\HttpClient\HttpClient;
use App\Domain\Api\Exceptions\ApiMethodMissing;
use App\Domain\Api\Exceptions\ApiUrlMissing;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetOpportunity extends AbstractApiCall
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /** @var CreateSession $createSession */
    protected $createSession;

    /** @var SessionRepository $sessionRepository */
    protected $sessionRepository;

    /** @var string $url */
    protected $url = 'https://scanner.tradingview.com/crypto/scan';

    /** @var string $method */
    protected $method = 'POST';

    public function __construct(CreateSession $createSession, SessionRepository $sessionRepository)
    {
        $this->httpClient = HttpClient::create();
        $this->createSession = $createSession;
        $this->sessionRepository = $sessionRepository;

        parent::__construct();
    }

    /**
     * @return string
     *
     * @throws ApiMethodMissing
     * @throws ApiUrlMissing
     * @throws UnknownExchange
     */
    public function get()
    {
        try {
            $results = $this->callApi();

            if (isset($results->data) && \count($results->data) > 0) {
                foreach ($results->data as $result) {
                    $body = $result->d;

                    $market = $body[1];
                    $pair = ExchangeHelpers::getPairFormatByExchange($body[0], $market);

                    $currentlyTradingList = $this->getCurrentlyTradingList();

                    if (!in_array($pair, $currentlyTradingList)) {
                        $price = $body[2];
                        $oneMinuteChange = $body[3];
                        $fiveMinuteChange = $body[4];
                        $fifteenMinuteChange = $body[5];
                        $onHourChange = $body[6];
                        //if($oneMinuteChange > $fiveMinuteChange) {
                        $this->createSession->create($market, $pair, $price);
                        //}
                    }
                }
            } else {
                return OpportunityEnum::NoOpportunity;
            }
        } catch (ApiError $e) {
            return OpportunityEnum::ApiError;
        } catch (TooManyTradeInProgress $e) {
            return OpportunityEnum::TooManyTradeInProgress;
        }

        return OpportunityEnum::Success;
    }

    /**
     * @return array
     *
     * @throws TooManyTradeInProgress
     */
    private function getCurrentlyTradingList()
    {
        $currentlyTradingList = $this->sessionRepository->getPairCurrentlyTrading();

        if (\count($currentlyTradingList) >= $_ENV['MAX_TRADING_PROGRESS']) {
            throw new TooManyTradeInProgress();
        }

        return $currentlyTradingList;
    }

    /**
     * @return mixed|string
     *
     * @throws ApiError
     * @throws ApiMethodMissing
     * @throws ApiUrlMissing
     */
    private function callApi()
    {
        $options = [
                'json' => [
                    'filter' => [
                            0 => [
                                    'left' => 'Volatility.D',
                                    'operation' => 'nempty',
                                ],
                            1 => [
                                    'left' => 'exchange',
                                    'operation' => 'equal',
                                    'right' => 'BITTREX',
                                ],
                            2 => [
                                    'left' => 'volume',
                                    'operation' => 'egreater',
                                    'right' => 1000000,
                                ],
                            3 => [
                                    'left' => 'change',
                                    'operation' => 'greater',
                                    'right' => 1,
                                ],
                            4 => [
                                    'left' => 'change|1',
                                    'operation' => 'greater',
                                    'right' => 0,
                                ],
                            5 => [
                                    'left' => 'change|5',
                                    'operation' => 'greater',
                                    'right' => 0,
                                ],
                            6 => [
                                    'left' => 'Volatility.D',
                                    'operation' => 'greater',
                                    'right' => 15,
                                ],
                            7 => [
                                    'left' => 'BBPower',
                                    'operation' => 'greater',
                                    'right' => 1.0E-6,
                                ],
                            8 => [
                                    'left' => 'name,description',
                                    'operation' => 'match',
                                    'right' => 'btc',
                                ],
                        ],
                    'options' => [
                            'lang' => 'fr',
                        ],
                    'symbols' => [
                            'query' => [
                                    'types' => [
                                        ],
                                ],
                            'tickers' => [
                                ],
                        ],
                    'columns' => [
                            0 => 'name',
                            1 => 'exchange',
                            2 => 'close',
                            3 => 'change|1',
                            4 => 'change|5',
                            5 => 'change|15',
                            6 => 'change|60',
                            7 => 'description',
                            8 => 'name',
                            9 => 'subtype',
                            10 => 'update_mode',
                            11 => 'pricescale',
                            12 => 'minmov',
                            13 => 'fractional',
                            14 => 'minmove2',
                        ],
                    'sort' => [
                            'sortBy' => 'Volatility.D',
                            'sortOrder' => 'desc',
                        ],
                    'range' => [
                            0 => 0,
                            1 => 150,
                        ],
                ],
            ];

        return $this->call($options, ApiInputEnum::JSON);
    }
}
