<?php
namespace PuzzleGame\Action;

use StateMachine\Action;
use StateMachine\State;
use Symfony\Component\HttpFoundation\Request;

class ClearSelection implements Action
{

    /**
     * @param Request $context
     * @param State $state

     */
    public function execute($context, State $state)
    {
        $state->removeVariable('selectedBox');
    }
}