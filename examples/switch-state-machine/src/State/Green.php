<?php declare(strict_types=1);

namespace SwitchStateMachine\State;

use StateMachine\State;

final class Green extends State
{

    public function getOutput(): string
    {
        return 'Green';
    }
}