<?php
namespace SwitchStateMachine\State;

use StateMachine\State;

class Red extends State
{
    /**
     * @return string
     */
    public function getOutput()
    {
        return 'Red';
    }
}