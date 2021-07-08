<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use GuzzleHttp\Psr7\ServerRequest;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$request = ServerRequest::fromGlobals();

session_start();

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

//load from last state or initialize
$sm = $_SESSION['puzzleGameStateMachine'] ?? \PuzzleGame\LogicPuzzleFactory::create();

$sm->handle($request);

//prepare renderer

$state = $sm->getState();
// save last state
$_SESSION['puzzleGameStateMachine'] = $sm;


$stateOutput = $state->getOutput() ?? [];
$stateOutput['debug'] = $sm->executionLog;

$stateReflection = new \ReflectionClass($state);

header('Content-Type: text/html');
echo $twig->render($stateReflection->getShortName() . '.twig', $stateOutput);
