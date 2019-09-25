<?php

namespace App\Command;

use App\Domain\Api\Exceptions\ApiMethodMissing;
use App\Domain\Api\Exceptions\ApiUrlMissing;
use App\Domain\Exchange\Exceptions\UnknownExchange;
use App\Domain\TradingView\Opportunity\GetOpportunity;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckOpportunityCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:check-opportunity';

    /** @var GetOpportunity $getPotentialInterest */
    protected $getPotentialInterest;

    public function __construct(GetOpportunity $getPotentialInterest)
    {
        $this->getPotentialInterest = $getPotentialInterest;

        parent::__construct();
    }

    protected function configure()
    {
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     *
     * @throws ApiMethodMissing
     * @throws ApiUrlMissing
     * @throws UnknownExchange
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo date('Y-m-d H:i:s').' - '.$this->getPotentialInterest->get()."\n";
    }
}
