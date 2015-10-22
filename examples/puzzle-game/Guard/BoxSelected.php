<?php
namespace PuzzleGame\Guard;

use StateMachine\Guard;
use StateMachine\State;
use Symfony\Component\HttpFoundation\Request;

class BoxSelected implements Guard
{

    /**
     * @param Request $request
     * @param State $state
     * @return bool
     */
    public function isAllowed(Request $request, State $state)
    {
        $selectedBoxId = $request->query->get('selectedBox', false);
        $boxes = $state->getStateMachine()->getVariable('boxes', false);

        return $request->query->has('selectedBox') && $boxes && isset($boxes[$selectedBoxId]) && !$state->getVariable('selectedBox', false);
    }
}