<?php
namespace StateMachine;

/**
 * Interface Action
 * @package StateMachine
 */
interface Action
{
    /**
     * @param $context
     * @param State $state
     * @return
     */
    public function execute($context, State $state);
}