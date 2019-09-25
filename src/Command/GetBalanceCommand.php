<?php

namespace App\Command;

use App\Domain\Exchange\ExchangeHelpers;
use App\Domain\Exchange\Interfaces\ExchangeGetBalanceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetBalanceCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:get-balance';

    public function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Get a pair ticker from an exchange.')
            ->addArgument('Exchange', InputArgument::REQUIRED, 'Which Echange ?')
            ->addArgument('Currency', InputArgument::REQUIRED, 'Which Currency ?')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string $exchange */
        $exchange = $input->getArgument('Exchange');

        /** @var string $currency */
        $currency = $input->getArgument('Currency');

        $className = ExchangeHelpers::getClassName($exchange, 'GetBalance');

        /** @var ExchangeGetBalanceInterface $getBalance */
        $getBalance = new $className();

        dump($getBalance->getBalance($currency));
    }
}
