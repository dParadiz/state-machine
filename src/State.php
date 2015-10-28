<?php
namespace StateMachine;

class State
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
     * @param $context
     */
    public function executeEntryActions($context)
    {

        foreach ($this->entryActions as $action) {
            $this->getStateMachine()->executionLog[] = 'Entry action ' . get_class($action);
            $action->execute($context, $this);
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
     * @param $context
     */
    public function executeExitActions($context)
    {
        foreach ($this->exitActions as $action) {
            $this->getStateMachine()->executionLog[] = 'Exit action ' . get_class($action);
            $action->execute($context, $this);
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