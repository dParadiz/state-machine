<?php
namespace PuzzleGame\State;

use StateMachine\State;

class LabelSelection extends State
{
    const SELECTED_BOX_PROPERTY = 'selectedBox';

    /**
     * @return array
     */
    public function getOutput()
    {
        return [
            'boxes' =>$this->getStateMachine()->getVariable('boxes', []),
            'selectedBox' => $this->getVariable(self::SELECTED_BOX_PROPERTY, false),
            'boxContent' => $this->getStateMachine()->getVariable('boxContent', [])
        ];
    }
}