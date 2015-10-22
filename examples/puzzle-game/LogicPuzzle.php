<?php
namespace PuzzleGame;

use StateMachine;
use Symfony\Component\HttpFoundation\Response;

class LogicPuzzle extends StateMachine\StateMachine
{
    /**
     * State machine initialization
     */
    public function initialize()
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

        $this->addState($initial);
        $this->addState($boxSelection);
        $this->addState($labelSelection);
        $this->addState($completed);
        $this->addState($failed);

        $this->setInitialState($initial);
    }

    /**
     * @return Response
     */
    protected function getOutput()
    {
        if (null === $this->currentState) {
            return null;
        }

        $stateReflection = new \ReflectionClass($this->currentState);

        ob_start();
        extract($this->currentState->getOutput());
        include EXAMPLE_PUZZLE_TEMPLATES . '/' . $stateReflection->getShortName() . '.phtml' ;
        unset($stateReflection);
        return new Response(ob_get_clean());
    }
}