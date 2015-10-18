<?php

namespace StateMachine;


use Symfony\Component\HttpFoundation\Request;

abstract class StateMachine
{
    /**
     * @var State
     */
    protected $currentState;

    protected $initialState;
    /**
     * @var State[]
     */
    protected $states = [];

    public function addState(State $state)
    {
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
     * @param Request $request
     */
    public function handle(Request $request)
    {
        if (null === $this->currentState) {
            throw new \RuntimeException('Initial state must be set.');
        }

        $this->currentState->executeEntryActions($request);

        foreach ($this->currentState->getTransitions() as $transition) {

            if ($transition->canBeExecuted($request)) {
                // exit current state
                $this->currentState->executeExitActions($request);
                // do transition action
                $transition->execute($request);
                // set new state
                $this->currentState = $transition->getEndState();
                // only one transition can be executed for current state
                break;
            }
        }
    }

    /**
     * @return State
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * State machine initialization
     */
    abstract public function initialize();

}