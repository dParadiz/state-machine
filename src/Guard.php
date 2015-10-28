<?php
namespace StateMachine;


interface Guard
{
    /**
     * @param $context
     * @param State $state
     * @return bool
     */
    public function isAllowed($context, State $state);
}