<?php
namespace PuzzleGame\Guard;

use StateMachine\Guard;
use StateMachine\State;
use Symfony\Component\HttpFoundation\Request;

class StartNew implements Guard
{

    /**
     * @param Request $request
     * @param State $state
     * @return bool
     */
    public function isAllowed($request, State $state)
    {
        return $request->query->has('tryAgain');
    }
}