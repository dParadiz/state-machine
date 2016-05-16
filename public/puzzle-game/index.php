<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PuzzleGame\LogicPuzzle;

$request = Request::createFromGlobals();

$session = new Session();
$session->start();

//$session->remove('puzzleGameStateMachine');
//load from last state or initialize
if ($session->has('puzzleGameStateMachine')) {
    $sm = $session->get('puzzleGameStateMachine');
} else {
    $sm =  \PuzzleGame\LogicPuzzleFactory::create();    
}

$sm->handle($request);

//prepare renderer
$loader = new Twig_Loader_Filesystem(__DIR__ .'/../../examples/puzzle-game/templates');
$twig = new Twig_Environment($loader);

$response = $sm->getOutput($twig);
// save last state
$session->set('puzzleGameStateMachine', $sm);

$response->send();
