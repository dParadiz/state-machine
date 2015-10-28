<?php
namespace PuzzleGame\Guard;

use StateMachine\Guard;
use StateMachine\State;
use Symfony\Component\HttpFoundation\Request;

class ValidLabeling implements Guard
{

    /**
     * @param Request $request
     * @param State $state
     * @return bool
     */
    public function isAllowed($request, State $state)
    {
        $validLabels = false;
        if ($request->query->has('newBoxLabels')) {
            $boxes = $state->getStateMachine()->getVariable('boxes', []);
            $newLabeling = $request->query->get('newBoxLabels', []);

            foreach ($boxes as $key => $box) {
                if (isset($newLabeling[$key]) && $box['content'] == $newLabeling[$key]) {
                    $validLabels = true;
                } else {
                    $validLabels = false;
                    break;
                }
            }
        }

        return $validLabels;
    }
}