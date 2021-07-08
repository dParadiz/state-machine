<?php declare(strict_types=1);

namespace SwitchStateMachine\State;

use StateMachine\State;

final class Blue extends State
{
    public function getOutput(): string
    {
        return 'Blue';
    }
}