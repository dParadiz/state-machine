<?php
namespace StateMachine;

use Symfony\Component\HttpFoundation\Request;

interface Guard
{
    /**
     * @param Request $request
     * @param State $state
     * @return bool
     */
    public function isAllowed(Request $request, State $state);
}