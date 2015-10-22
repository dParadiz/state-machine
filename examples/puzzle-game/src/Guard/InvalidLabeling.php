<?php
namespace PuzzleGame\Guard;

use StateMachine\Guard;
use StateMachine\State;
use Symfony\Component\HttpFoundation\Request;

class InvalidLabeling implements Guard
{

    /**
     * @param Request $request
     * @param State $state
     * @return bool
     */
    public function isAllowed(Request $request, State $state)
    {
        $invalidLabels = false;
        if ($request->query->has('newBoxLabels')) {
            $boxes = $state->getStateMachine()->getVariable('boxes', []);
            $newLabeling = $request->query->get('newBoxLabels', []);
            foreach ($boxes as $key => $box) {
                if (isset($newLabeling[$key]) && $box['content'] == $newLabeling[$key]) {
                    $invalidLabels = false;
                } else {
                    $invalidLabels = true;
                    break;
                }
            }
        }

        return $invalidLabels;
    }
}