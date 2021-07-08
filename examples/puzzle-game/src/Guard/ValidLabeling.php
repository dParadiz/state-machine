<?php declare(strict_types=1);

namespace PuzzleGame\Guard;

use StateMachine\Guard;
use StateMachine\State;
use Psr\Http\Message\ServerRequestInterface;

final class ValidLabeling implements Guard
{
    public function isAllowed(ServerRequestInterface $request, State $state): bool
    {
        $queryParams = $request->getQueryParams();
        $validLabels = false;
        if (isset($queryParams['newBoxLabels'])) {
            $boxes = $state->getStateMachine()->getVariable('boxes', []);
            $newLabeling = $queryParams['newBoxLabels'] ?? [];

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