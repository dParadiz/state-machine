$<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


$request = Request::createFromGlobals();

$session = new Session();
$session->start();

// load state machine from last state or initialize it
if ($session->has('switchStateMachine')) {
    $sm = $session->get('switchStateMachine');
} else  {
    $container = new ContainerBuilder();
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../examples/switch-state-machine/config'));
    $loader->load('services.yml');

    $sm = $container->get('state_machine');
}

// process request by state machine and get output
$sm->handle($request);
// save last sate
$session->set('switchStateMachine', $sm);
//send response
$response = new Response($sm->getOutput());
$response->send();