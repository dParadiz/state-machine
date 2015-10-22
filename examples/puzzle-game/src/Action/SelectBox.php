<?php
namespace PuzzleGame\Action;

use PuzzleGame\State\LabelSelection;
use StateMachine\Action;
use StateMachine\State;
use Symfony\Component\HttpFoundation\Request;

class SelectBox implements Action
{

    /**
     * @param Request $request
     * @param State $state
     */
    public function execute(Request $request, State $state)
    {
        if ($state->getVariable(LabelSelection::SELECTED_BOX_PROPERTY, false) !== false) {
            return;
        }

        $selectedBoxId = $request->query->get(LabelSelection::SELECTED_BOX_PROPERTY, false);
        $boxes = $state->getStateMachine()->getVariable('boxes', false);

        if ($selectedBoxId && $boxes && isset($boxes[$selectedBoxId])) {
            $state->setVariable(LabelSelection::SELECTED_BOX_PROPERTY, (int)$selectedBoxId);
        }
    }
}