<?php
namespace StateMachine;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface Action
 * @package StateMachine
 */
interface Action
{
    /**
     * @param Request $request
     * @param State $state
     * @return
     */
    public function execute(Request $request, State $state);
}