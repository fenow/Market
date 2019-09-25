<?php


Namespace App\Command;

use App\Domain\Exchange\ExchangeHelpers;
use App\Domain\Exchange\Interfaces\ExchangeGetBalanceInterface;
use App\Domain\Exchange\Interfaces\ExchangeGetOrderInterface;
use App\Domain\Exchange\Interfaces\ExchangeGetTickerInterface;
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
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $className = ExchangeHelpers::getClassName($input->getArgument('Exchange'), 'GetOrder');

        /** @var ExchangeGetOrderInterface $getOrder */
        $getOrder = new $className();

        dump($getOrder->getOrder($input->getArgument('Uuid')));
    }
}