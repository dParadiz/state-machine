<?php declare(strict_types=1);

namespace SwitchStateMachine\State;

use StateMachine\State;

final class Red extends State
{
    public function getOutput(): string
    {
        return 'Red';
    }
}