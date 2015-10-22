<?php
namespace PuzzleGame;

use StateMachine;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

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
     * @param Twig_Environment $twig
     * @return Response
     */
    public function getOutput(Twig_Environment $twig)
    {
        if (null === $this->currentState) {
            return null;
        }

        $stateOutput = $this->currentState->getOutput();
        if (null === $stateOutput) {
            $stateOutput = [];
        }
        $stateOutput['debug'] = $this->executionLog;

        $stateReflection = new \ReflectionClass($this->currentState);
        return new Response($twig->render($stateReflection->getShortName() . '.twig', $stateOutput));
    }
}