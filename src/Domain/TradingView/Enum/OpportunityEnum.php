<?php


namespace App\Domain\TradingView\Enum;

use Greg0ire\Enum\AbstractEnum;

final class OpportunityEnum extends AbstractEnum {
    const Success = 'Success';
    const TooManyTradeInProgress = 'TooManyTradeInProgress';
    const ApiError = 'ApiError';
    const NoOpportunity = 'NoOpportunity';
}