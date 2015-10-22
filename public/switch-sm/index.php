<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use SwitchStateMachine\SwitchStateMachine as StateMachine;

$request = Request::createFromGlobals();

$session = new Session();
$session->start();

// load state machine from last state or initialize it
if ($session->has('switchStateMachine')) {
    $sm = $session->get('switchStateMachine');
} else  {
    $sm = new StateMachine();
    $sm->initialize();
}
// process request by state machine and get output
$smOutput = $sm->handle($request);
// save last sate
$session->set('switchStateMachine', $sm);
//send response
$response = new Response($smOutput);
$response->send();