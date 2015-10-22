<?php
namespace StateMachine;

use Symfony\Component\HttpFoundation\Request;

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
     * @param Request $request
     */
    public function execute(Request $request)
    {
    }

    /**
     * @param Request $request
     * @param State $state
     * @return bool
     */
    public function canBeExecuted(Request $request, State $state)
    {
        foreach ($this->guards as $guard) {
            if (!$guard->isAllowed($request, $state)) {
                return false;
            }
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