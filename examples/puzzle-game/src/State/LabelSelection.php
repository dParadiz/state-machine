<?php declare(strict_types=1);

namespace PuzzleGame\State;

use JetBrains\PhpStorm\ArrayShape;
use StateMachine\State;

final class LabelSelection extends State
{
    const SELECTED_BOX_PROPERTY = 'selectedBox';


    #[ArrayShape(
        [
            'boxes' => "array",
            'selectedBox' => "boolean",
            'boxContent' => "array"
        ]
    )]
    public function getOutput(): array
    {
        return [
            'boxes' => $this->getStateMachine()->getVariable('boxes', []),
            'selectedBox' => $this->getVariable(self::SELECTED_BOX_PROPERTY, false),
            'boxContent' => $this->getStateMachine()->getVariable('boxContent', [])
        ];
    }
}