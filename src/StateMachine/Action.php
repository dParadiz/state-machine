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
     */
    public function execute(Request $request);
}