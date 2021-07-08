<?php declare(strict_types=1);

namespace StateMachine;

use Psr\Http\Message\ServerRequestInterface;

abstract class State
{
    use Variables;

    /**
     * @var Transition[]
     */
    protected array $transitions = [];

    /**
     * @var Action[]
     */
    protected array $entryActions = [];

    /**
     * @var Action[]
     */
    protected array $exitActions = [];


    protected StateMachine $stateMachine;

    public function setStateMachine(StateMachine $stateMachine): void
    {
        $this->stateMachine = $stateMachine;
    }


    public function getStateMachine(): StateMachine
    {
        return $this->stateMachine;
    }

    public function addTransition(Transition $transition): void
    {
        $this->transitions[] = $transition;
    }


    public function addEntryAction(Action $action): void
    {
        $this->entryActions[] = $action;
    }

    public function executeEntryActions(ServerRequestInterface $request): void
    {
        foreach ($this->entryActions as $action) {
            $this->getStateMachine()->executionLog[] = 'Entry action ' . get_class($action);
            $action->execute($request, $this);
        }
    }


    public function addExitAction(Action $action): void
    {
        $this->exitActions[] = $action;
    }

    public function executeExitActions(ServerRequestInterface $request): void
    {
        foreach ($this->exitActions as $action) {
            $this->getStateMachine()->executionLog[] = 'Exit action ' . get_class($action);
            $action->execute($request, $this);
        }
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }

    public function getOutput(): mixed
    {
        return null;
    }
}