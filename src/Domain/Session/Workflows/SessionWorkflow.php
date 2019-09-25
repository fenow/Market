<?php


namespace App\Domain\Session\Workflows;

use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\SupportStrategy\InstanceOfSupportStrategy;

class SessionWorkflow
{
    const SESSION_PLACE_BUY_ORDER = 'session_place_buy_order';
    const SESSION_ORDER_BUYED = 'session_order_buyed';
    const SESSION_PLACE_SELL_ORDER = 'session_place_sell_order';
    const SESSION_ORDER_SOLD = 'session_order_sold';

    /** @var Workflow $workflow */
    protected  $workflow;

    /** @var ContainerInterface $container */
    protected $container;

    /**
     * SessionWorkflow constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;

        $definitionBuilder = new DefinitionBuilder();
        $definition = $definitionBuilder->addPlaces(SessionStatusEnum::getConstants())
            ->addTransition(new Transition(self::SESSION_PLACE_BUY_ORDER, SessionStatusEnum::Created, SessionStatusEnum::Buying))
            ->addTransition(new Transition(self::SESSION_ORDER_BUYED, SessionStatusEnum::Buying, SessionStatusEnum::Buyed))
            ->addTransition(new Transition(self::SESSION_PLACE_SELL_ORDER, SessionStatusEnum::Buyed, SessionStatusEnum::Selling))
            ->addTransition(new Transition(self::SESSION_ORDER_SOLD, SessionStatusEnum::Selling, SessionStatusEnum::Sold))
            ->build()
        ;

        $this->workflow = new Workflow(
            $definition,
            new MethodMarkingStore(true, 'status')
        );
    }

    /**
     * @param Session $session
     * @return bool
     */
    public function run(Session $session): bool {
        $registry = new Registry();
        $registry->addWorkflow($this->workflow, new InstanceOfSupportStrategy(Session::class));

        $workflow = $registry->get($session);

        /** @var Transition $transition */
        $transition = current($workflow->getEnabledTransitions($session));
        $nextStep = current($transition->getTos());

        return $this->nextStep($session, $nextStep);
    }

    /**
     * @param Session $session
     * @param string $nextStep
     * @return bool
     */
    private function nextStep(Session $session, string $nextStep): bool {
        $service = sprintf('app.%s.%s.order', strtolower($session->getMarket()), $nextStep);
        return $this->container->get($service)->execute($session);
    }
}