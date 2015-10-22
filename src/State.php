<?php
namespace StateMachine;

use Symfony\Component\HttpFoundation\Request;

abstract class State
{
    use Variables;

    /**
     * List of transitions from this state
     * @var Transition[]
     */
    protected $transitions = [];

    /**
     * List of actions that are executed when entering the state
     * @var Action[]
     */
    protected $entryActions = [];

    /**
     * List of actions that are executed when exiting the state
     * @var Action[]
     */
    protected $exitActions = [];

    /**
     * @var StateMachine
     */
    protected $stateMachine;

    /**
     * @param StateMachine $stateMachine
     */
    public function setStateMachine($stateMachine)
    {
        $this->stateMachine = $stateMachine;
    }

    /**
     * @return StateMachine
     */
    public function getStateMachine()
    {
        return $this->stateMachine;
    }

    /**
     * @param Transition $transition
     */
    public function addTransition(Transition $transition)
    {
        $this->transitions[] = $transition;
    }

    /**
     * @param Action $action
     */
    public function addEntryAction(Action $action)
    {
        $this->entryActions[] = $action;
    }

    /**
     * @param Request $request
     */
    public function executeEntryActions(Request $request)
    {

        foreach ($this->entryActions as $action) {
            $this->getStateMachine()->executionLog[] = 'Entry action ' . get_class($action);
            $action->execute($request, $this);
        }
    }

    /**
     * @param Action $action
     */
    public function addExitAction(Action $action)
    {
        $this->exitActions[] = $action;
    }

    /**
     * @param Request $request
     */
    public function executeExitActions(Request $request)
    {
        foreach ($this->exitActions as $action) {
            $this->getStateMachine()->executionLog[] = 'Exit action ' . get_class($action);
            $action->execute($request, $this);
        }
    }

    /**
     * @return Transition[]
     */
    public function getTransitions()
    {
        return $this->transitions;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {

    }

}