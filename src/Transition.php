<?php
namespace StateMachine;


class Transition
{
    /**
     * @var State
     */
    protected $endState;

    /** @var Guard[] */
    protected $guards = [];

    /**
     * Transition constructor.
     * @param State $endState
     * @param Guard[] $guards
     */
    public function __construct(State $endState, array $guards = [])
    {
        $this->endState = $endState;
        $this->guards = $guards;
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
     * @param State $state
     * @return bool
     */
    public function canBeExecuted($context, State $state)
    {
        foreach ($this->guards as $guard) {

            if (!$guard->isAllowed($context, $state)) {
                $state->getStateMachine()->executionLog[] = 'Guard ' . get_class($guard) . ' prevents transition to ' . get_class($this->endState);
                return false;
            }
            $state->getStateMachine()->executionLog[] = 'Guard ' . get_class($guard) . ' allows transition to ' . get_class($this->endState);
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