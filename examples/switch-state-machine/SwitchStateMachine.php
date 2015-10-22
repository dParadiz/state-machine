<?php
namespace SwitchStateMachine;

use StateMachine;

class SwitchStateMachine extends StateMachine\StateMachine
{

    public function initialize()
    {
        $redState = new State\Red();
        $greenState = new State\Green();
        $blueState = new State\Blue();
        $initialState = new State\InitialState();

        $initialState->addTransition(new StateMachine\Transition($redState));
        $redState->addTransition(new StateMachine\Transition($blueState));
        $blueState->addTransition(new StateMachine\Transition($greenState));
        $greenState->addTransition(new StateMachine\Transition($redState));

        $this->addState($redState);
        $this->addState($blueState);
        $this->addState($greenState);

        $this->setInitialState($initialState);
    }
}