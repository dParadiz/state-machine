<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use SwitchStateMachine\SwitchStateMachineFactory as StateMachine;
use GuzzleHttp\Psr7\ServerRequest;

$request = ServerRequest::fromGlobals();

session_start();
// load state machine from last state or initialize it
$sm = $_SESSION['switchStateMachine'] ?? StateMachine::create();
// process request by state machine and get output
$sm->handle($request);
// save last sate
$_SESSION['switchStateMachine'] = $sm;
//send response
echo $sm->getOutput();