<?php declare(strict_types=1);

namespace PuzzleGame\State;

use JetBrains\PhpStorm\ArrayShape;
use StateMachine\State;

final class BoxSelection extends State
{
    const APPLES = 'Apples';
    const ORANGES = 'Oranges';
    const ORANGES_APPLES = 'Oranges and Apples';


    #[ArrayShape(['boxes' => "array"])]
    public function getOutput(): array
    {
        $boxContent = [self::APPLES, self::ORANGES, self::ORANGES_APPLES];

        shuffle($boxContent);

        $indexes = array_flip($boxContent);

        $boxLabels = [];

        $selected = rand(0, 100) > 50 ? self::ORANGES : self::APPLES;
        $notSelected = $selected == self::APPLES ? self::ORANGES : self::APPLES;

        $boxLabels[$indexes[self::ORANGES_APPLES]] = $selected;
        $boxLabels[$indexes[$selected]] = $notSelected;
        $boxLabels[$indexes[$notSelected]] = self::ORANGES_APPLES;

        ksort($boxLabels);
        $boxes = [];
        foreach ($boxContent as $key => $content) {
            $boxes[$key] = [
                'content' => $content,
                'label' => $boxLabels[$key]
            ];
        }

        // set variables in state machine scope so other states within state machine can also access them
        $this->getStateMachine()->setVariable('boxes', $boxes);
        $this->getStateMachine()->setVariable('boxContent', [self::APPLES, self::ORANGES, self::ORANGES_APPLES]);

        return [
            'boxes' => $boxes
        ];
    }
}