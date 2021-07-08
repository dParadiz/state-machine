<?php declare(strict_types=1);

namespace StateMachine;

use Psr\Http\Message\ServerRequestInterface;

interface Guard
{
    public function isAllowed(ServerRequestInterface $request, State $state): bool;
}