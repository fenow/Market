<?php


Namespace App\Command;

use App\Domain\Session\CreateSession;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateSessionCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:session-create';

    /** @var CreateSession $createSession */
    protected $createSession;

    public function __construct(CreateSession $createSession)
    {
        $this->createSession = $createSession;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Create a new marketplace session.')
            ->addArgument('market', InputArgument::REQUIRED, 'Which Market ?')
            ->addArgument('pair', InputArgument::REQUIRED, 'Which Pair ?')
            ->addArgument('price', InputArgument::REQUIRED, 'Which Price ?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string $market */
        $market = $input->getArgument('market');

        /** @var float $price */
        $price = $input->getArgument('price');

        /** @var string $pair */
        $pair = $input->getArgument('pair');

        $this->createSession->create(
            $market,
            $pair,
            $price
        );
    }
}
