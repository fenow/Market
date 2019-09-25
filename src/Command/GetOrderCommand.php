<?php

namespace App\Command;

use App\Domain\Exchange\ExchangeHelpers;
use App\Domain\Exchange\Interfaces\ExchangeGetOrderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetOrderCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:get-order';

    public function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Get an order from an exchange.')
            ->addArgument('Exchange', InputArgument::REQUIRED, 'Which Echange ?')
            ->addArgument('Uuid', InputArgument::REQUIRED, 'Which Uuid ?')
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

        /** @var string $uuid */
        $uuid = $input->getArgument('Uuid');

        $className = ExchangeHelpers::getClassName($exchange, 'GetOrder');

        /** @var ExchangeGetOrderInterface $getOrder */
        $getOrder = new $className();

        dump($getOrder->getOrder($uuid));
    }
}
