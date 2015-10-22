<?php
namespace PuzzleGame\Action;

use StateMachine\Action;
use StateMachine\State;
use Symfony\Component\HttpFoundation\Request;

class ClearSelection implements Action
{

    /**
     * @param Request $request
     * @param State $state

     */
    public function execute(Request $request, State $state)
    {
        $state->removeVariable('selectedBox');
    }
}