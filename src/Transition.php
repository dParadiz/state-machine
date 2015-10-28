<?php
namespace StateMachine;


class Transition
{
    /**
     * @var State
     */
    protected $endState;

    /**
     * @var State
     */
    protected $startingState;

    /** @var Guard[] */
    protected $guards = [];

    /**
     * Transition constructor.
     * @param State $endState
     * @param Guard[] $guards
     */
    public function __construct($endState, array $guards = [])
    {
        $this->endState = $endState;
        $this->guards = $guards;
    }

    /**
     * @param State $startingState
     */
    public function setStartingState($startingState)
    {
        $this->startingState = $startingState;
    }

    /**
     * Transition action that is executed before entering end state
     * @param $context
     */
    public function execute($context)
    {
    }

    /**
     * @param $context
     * @return bool
     */
    public function canBeExecuted($context)
    {
        if (null === $this->startingState) {
            throw new \RuntimeException('Starting state must be set before state can be executed');
        }

        foreach ($this->guards as $guard) {

            if (!$guard->isAllowed($context, $this->startingState)) {
                $this->startingState->getStateMachine()->executionLog[] = 'Guard ' . get_class($guard) . ' prevents transition to ' . get_class($this->endState);
                return false;
            }
            $this->startingState->getStateMachine()->executionLog[] = 'Guard ' . get_class($guard) . ' allows transition to ' . get_class($this->endState);
        }

        return true;
    }

    /**
     * @return State
     */
    public function getEndState()
    {
        return $this->endState;
    }

}