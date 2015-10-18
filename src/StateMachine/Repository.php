<?php
namespace StateMachine;

interface Repository
{
    /**
     * @return StateMachine
     */
    public function fetch();

    /**
     * @param StateMachine $stateMachine
     */
    public function store(StateMachine $stateMachine);
}