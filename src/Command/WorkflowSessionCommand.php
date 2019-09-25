<?php

namespace App\Command;

use App\Domain\Session\Workflows\SessionWorkflow;
use App\Entity\Session;
use App\Repository\SessionRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WorkflowSessionCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:session-workflow';

    /** @var SessionRepository $sessionRepository */
    protected $sessionRepository;

    /** @var SessionWorkflow $sessionWorkflow */
    protected $sessionWorkflow;

    public function __construct(SessionRepository $sessionRepository, SessionWorkflow $sessionWorkflow)
    {
        $this->sessionRepository = $sessionRepository;
        $this->sessionWorkflow = $sessionWorkflow;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sessions = $this->sessionRepository->getSessionsCurrentlyTrade();

        /** @var Session $session */
        foreach ($sessions as $session) {
            $this->sessionWorkflow->run($session);
        }
    }
}
