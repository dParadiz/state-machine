<?php

namespace PuzzleGame;

use StateMachine;

class LogicPuzzleFactory
{
    /**
     * @return LogicPuzzle
     */
    public static function create()
    {
        $initial = new State\Initial();
        $boxSelection = new State\BoxSelection();
        $labelSelection = new State\LabelSelection();
        $completed = new State\Completed();
        $failed = new State\Failed();

        $initial->addTransition(new StateMachine\Transition($boxSelection));

        $boxSelection->addTransition(new StateMachine\Transition($labelSelection, [
            new Guard\BoxSelected()
        ]));

        $labelSelection->addEntryAction(new Action\SelectBox());
        $labelSelection->addExitAction(new Action\ClearSelection());

        $labelSelection->addTransition(new StateMachine\Transition($completed, [
            new Guard\ValidLabeling()
        ]));
        $labelSelection->addTransition(new StateMachine\Transition($failed, [
            new Guard\InvalidLabeling()
        ]));

        $completed->addTransition(new StateMachine\Transition($boxSelection, [
            new Guard\StartNew()
        ]));

        $failed->addTransition(new StateMachine\Transition($boxSelection, [
            new Guard\StartNew()
        ]));

        $sm = new LogicPuzzle();
        $sm->addState($initial);
        $sm->addState($boxSelection);
        $sm->addState($labelSelection);
        $sm->addState($completed);
        $sm->addState($failed);

        $sm->setInitialState($initial);
        return $sm;
    }
}