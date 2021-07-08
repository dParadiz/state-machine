<?php declare(strict_types=1);

namespace PuzzleGame\Action;

use PuzzleGame\State\LabelSelection;
use StateMachine\Action;
use StateMachine\State;
use Psr\Http\Message\ServerRequestInterface;

final class SelectBox implements Action
{

    public function execute(ServerRequestInterface $request, State $state): void
    {
        if ($state->getVariable(LabelSelection::SELECTED_BOX_PROPERTY, false) !== false) {
            return;
        }

        $selectedBoxId = $request->getQueryParams()[LabelSelection::SELECTED_BOX_PROPERTY] ?? false;
        $boxes = $state->getStateMachine()->getVariable('boxes', false);

        if ($selectedBoxId && $boxes && isset($boxes[$selectedBoxId])) {
            $state->setVariable(LabelSelection::SELECTED_BOX_PROPERTY, (int)$selectedBoxId);
        }
    }
}