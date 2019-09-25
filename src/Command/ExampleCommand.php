<?php

namespace App\Command;

use App\Domain\Exchange\Exceptions\UnknownExchange;
use App\Domain\Exchange\ExchangeHelpers;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:example';

    public function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Execute some code')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     *
     * @throws UnknownExchange
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo ExchangeHelpers::getPairFormatByExchange('EXPBTC', 'BITTREX');
    }
}
