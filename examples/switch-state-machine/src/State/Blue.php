<?php
namespace SwitchStateMachine\State;

use StateMachine\State;

class Blue extends State
{
    /**
     * @return string
     */
    public function getOutput()
    {
        return 'Blue';
    }
}