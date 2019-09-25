<?php


Namespace App\Command;

use App\Domain\Exchange\ExchangeHelpers;
use App\Domain\Exchange\Interfaces\ExchangeGetTickerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetTickerCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:get-ticker';


    public function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Get a pair ticker from an exchange.')
            ->addArgument('Exchange', InputArgument::REQUIRED, 'Which Echange ?')
            ->addArgument('pair', InputArgument::REQUIRED, 'Which Pair ?')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {


        /** @var string $exchange */
        $exchange = $input->getArgument('Exchange');

        /** @var string $pair */
        $pair = $input->getArgument('pair');

        $className = ExchangeHelpers::getClassName($exchange, 'GetTicker');

        /** @var ExchangeGetTickerInterface $getTicker */
        $getTicker = new $className();

        dump($getTicker->getTicker($pair));
    }
}
