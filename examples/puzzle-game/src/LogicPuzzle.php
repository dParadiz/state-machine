<?php
namespace PuzzleGame;

use StateMachine;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class LogicPuzzle extends StateMachine\StateMachine
{
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