<?php declare(strict_types=1);

namespace PuzzleGame\Guard;

use StateMachine\Guard;
use StateMachine\State;
use Psr\Http\Message\ServerRequestInterface;

final class StartNew implements Guard
{
    public function isAllowed(ServerRequestInterface $request, State $state): bool
    {
        return isset($request->getQueryParams()['tryAgain']);
    }
}