<?php
namespace SwitchStateMachine\State;

use StateMachine\State;

class Green extends State
{
    /**
     * @return string
     */
    public function getOutput()
    {
        return 'Green';
    }
}