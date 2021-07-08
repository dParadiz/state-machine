<?php declare(strict_types=1);

namespace StateMachine;

use Psr\Http\Message\ServerRequestInterface;

interface Action
{
    public function execute(ServerRequestInterface $request, State $state): void;
}