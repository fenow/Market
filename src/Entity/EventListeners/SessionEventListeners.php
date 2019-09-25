<?php

namespace App\Entity\EventListeners;

use App\Domain\SessionLog\CreateSessionLog;
use App\Entity\Session;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class SessionEventListeners
{
    /**
     * @var CreateSessionLog
     */
    protected $sessionLog;

    public function __construct(CreateSessionLog $createSessionLog)
    {
        $this->sessionLog = $createSessionLog;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        /* @var Session $entity */
        if (!$entity instanceof Session) {
            return;
        }

        $this->sessionLog->create($entity);
    }
}
