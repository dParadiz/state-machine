<?php
define('EXAMPLE_PUZZLE_TEMPLATES', __DIR__ . '/templates');
require_once __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PuzzleGame\LogicPuzzle;

$request = Request::createFromGlobals();

$session = new Session();
$session->start();

//load from last state or initialize
if ($session->has('puzzleGameStateMachine')) {
    $sm = $session->get('puzzleGameStateMachine');
} else {
    $sm = new LogicPuzzle();
    $sm->initialize();
}

$response = $sm->handle($request);

// save last state
$session->set('puzzleGameStateMachine', $sm);

$response->send();
