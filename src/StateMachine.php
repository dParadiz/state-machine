<?php declare(strict_types=1);

namespace StateMachine;


class StateMachine
{
    use Variables;

    /**
     * Debugging log
     * @var array
     */
    public array $executionLog = [];

    protected ?State $currentState = null;

    /**
     * @var State[]
     */
    protected array $states = [];

    public function addState(State $state)
    {
        $state->setStateMachine($this);
        $this->states[] = $state;
    }

    /**
     * @param State $state
     */
    public function setInitialState(State $state)
    {
        $this->currentState = $state;
    }

    /**
     * @param $request
     */
    public function handle($request)
    {
        if (null === $this->currentState) {
            throw new \RuntimeException('Initial state must be set.');
        }
        $this->executionLog = [];
        $this->executionLog[] = 'Starting at state ' . get_class($this->currentState);

        foreach ($this->currentState->getTransitions() as $transition) {

            // get transition that can be executed or stay in current state
            if ($transition->canBeExecuted($request, $this->currentState)) {
                // exit current state
                $this->currentState->executeExitActions($request);
                // do transition action
                $transition->execute($request);
                // set new state
                $this->currentState = $transition->getEndState();
                $this->currentState->executeEntryActions($request);
                $this->executionLog[] = 'Moving to state ' . get_class($this->currentState);
                // only one transition can be executed for current state
                break;
            }
        }
    }

    public function getOutput(): mixed
    {
        if (null === $this->currentState) {
            return null;
        }

        return $this->currentState->getOutput();
    }

    public function getState(): ?State
    {
        return $this->currentState;
    }
}