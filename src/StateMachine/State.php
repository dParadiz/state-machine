<?php
namespace StateMachine;

use Symfony\Component\HttpFoundation\Request;

abstract class State
{
    /**
     * @var Transition[]
     */
    protected $transitions = [];
    /**
     * @var Action[]
     */
    protected $entryActions = [];
    /**
     * @var Action[]
     */
    protected $exitActions = [];
    /**
     * @var \ArrayObject
     */
    private $variables;

    /**
     * State constructor.
     */
    public function __construct()
    {
        $this->variables = new \ArrayObject();
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
            $action->execute($request);
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
            $action->execute($request);
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
    abstract public function getOutput();

    /**
     * @param $name
     * @param $value
     */
    protected function setVariable($name, $value)
    {
        $this->variables->offsetSet($name, $value);
    }

    /**
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    protected function getVariable($name, $default = null)
    {
        if ($this->variables->offsetExists($name)) {
            return $this->variables->offsetGet($name);
        }

        return $default;
    }
}