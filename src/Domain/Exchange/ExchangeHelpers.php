<?php


namespace App\Domain\Exchange;


use App\Domain\Exchange\Enum\ExchangeEnum;
use App\Domain\Exchange\Exceptions\UnknownExchange;

class ExchangeHelpers
{
    /**
     * @param string $exchange
     * @param string $verb
     * @return string
     */
    public static function getClassName(string $exchange, string $verb): string {
        $exchangeName = ucfirst(strtolower($exchange));
        return sprintf('App\Domain\Exchange\%s\%sExchange%s', $exchangeName, $exchangeName, $verb);
    }

    /**
     * @param string $pair
     * @param string $market
     * @return string
     * @throws UnknownExchange
     */
    public static function getPairFormatByExchange(string $pair, string $market): string {
        switch($market) {
            default:
                throw new UnknownExchange();

            case ExchangeEnum::BITTREX:
                $nbCharacters = \strlen($pair);
                $begin = $nbCharacters - 3;
                $first = substr($pair, $begin);
                $last = substr($pair, 0, $begin);
                return sprintf('%s-%s', $first, $last);
        }
    }

    /**
     * @param string $pair
     * @param string $market
     * @return string
     * @throws UnknownExchange
     */
    public static function getCurrencyByExchange(string $pair, string $market): string {
        switch($market) {
            default:
                throw new UnknownExchange();

            case ExchangeEnum::BITTREX:
                return current(explode('-', $pair));
        }
    }
}