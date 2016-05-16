<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use SwitchStateMachine\SwitchStateMachineFactory as StateMachine;

$request = Request::createFromGlobals();

$session = new Session();
$session->start();

// load state machine from last state or initialize it
if ($session->has('switchStateMachine')) {
    $sm = $session->get('switchStateMachine');
} else  {
    $sm = StateMachine::create();
}
// process request by state machine and get output
$sm->handle($request);
// save last sate
$session->set('switchStateMachine', $sm);
//send response
$response = new Response($sm->getOutput());
$response->send();