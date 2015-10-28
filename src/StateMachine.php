<?php
namespace StateMachine;

class StateMachine
{
    use Variables;

    /**
     * Debug log
     * @var array
     */
    public $executionLog = [];

    /**
     * @var State
     */
    protected $currentState;

    /**
     * @var State[]
     */
    protected $states = [];

    /**
     * @param State $state
     */
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
     * @param $context
     */
    public function handle($context)
    {
        if (null === $this->currentState) {
            throw new \RuntimeException('Initial state must be set.');
        }
        $this->executionLog = [];
        $this->executionLog[] = 'Starting at state ' . get_class($this->currentState);
        $this->currentState->executeEntryActions($context);

        foreach ($this->currentState->getTransitions() as $transition) {

            // get transition that can be executed or stay in current state
            if ($transition->canBeExecuted($context)) {
                // exit current state
                $this->currentState->executeExitActions($context);
                // do transition action
                $transition->execute($context);
                // set new state
                $this->currentState = $transition->getEndState();
                $this->currentState->executeEntryActions($context);
                $this->executionLog[] = 'Moving to state ' . get_class($this->currentState);
                // only one transition can be executed for current state
                break;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        if (null === $this->currentState) {
            return null;
        }
        return $this->currentState->getOutput();
    }
}