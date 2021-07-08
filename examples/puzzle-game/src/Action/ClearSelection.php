<?php declare(strict_types=1);

namespace PuzzleGame\Action;

use StateMachine\Action;
use StateMachine\State;
use Psr\Http\Message\ServerRequestInterface;

final class ClearSelection implements Action
{

    public function execute(ServerRequestInterface $request, State $state): void
    {
        $state->removeVariable('selectedBox');
    }
}