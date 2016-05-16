<?php
namespace SwitchStateMachine;

use StateMachine;

class SwitchStateMachineFactory
{

    /**
     * @return StateMachine\StateMachine
     */
    public static function create()
    {
        $redState = new State\Red();
        $greenState = new State\Green();
        $blueState = new State\Blue();
        $initialState = new State\InitialState();

        $initialState->addTransition(new StateMachine\Transition($redState));
        $redState->addTransition(new StateMachine\Transition($blueState));
        $blueState->addTransition(new StateMachine\Transition($greenState));
        $greenState->addTransition(new StateMachine\Transition($redState));

        $sm = new StateMachine\StateMachine();
        $sm->addState($redState);
        $sm->addState($blueState);
        $sm->addState($greenState);

        $sm->setInitialState($initialState);

        return $sm;
    }
}