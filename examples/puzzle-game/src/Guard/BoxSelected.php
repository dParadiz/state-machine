<?php declare(strict_types=1);

namespace PuzzleGame\Guard;

use StateMachine\Guard;
use StateMachine\State;
use Psr\Http\Message\ServerRequestInterface;

final class BoxSelected implements Guard
{


    public function isAllowed(ServerRequestInterface $request, State $state): bool
    {
        $queryParams = $request->getQueryParams();
        $selectedBoxId = $queryParams['selectedBox'] ?? false;
        $boxes = $state->getStateMachine()->getVariable('boxes', false);

        return isset($queryParams['selectedBox'])
            && $boxes !== false
            && isset($boxes[$selectedBoxId])
            && !$state->getVariable('selectedBox', false);
    }
}