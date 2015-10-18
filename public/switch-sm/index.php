<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


$request = Request::createFromGlobals();

$session = new Session();
$session->start();

$smRepository = new \StateMachine\SessionRepository($session);

$sm = $smRepository->fetch();

if (null === $sm) {
    $sm = new \SwitchStateMachine\SwitchStateMachine();
    $sm->initialize();
}

$sm->handle($request);

$smRepository->store($sm);

$response = new Response($sm->getCurrentState()->getOutput());
$response->send();