<?php
namespace StateMachine;

use Symfony\Component\HttpFoundation\Request;

interface Guard
{
    /**
     * @param Request $request
     * @return bool
     */
    public function isAllowed(Request $request);
}