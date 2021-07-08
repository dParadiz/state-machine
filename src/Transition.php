<?php declare(strict_types=1);

namespace StateMachine;

use Psr\Http\Message\ServerRequestInterface;

class Transition
{

    protected State $endState;

    /** @var Guard[] */
    protected array $guards = [];


    public function __construct(State $endState, array $guards = [])
    {
        $this->endState = $endState;
        $this->guards = $guards;
    }


    public function execute(ServerRequestInterface $request): void
    {
    }

    public function canBeExecuted(ServerRequestInterface $request, State $state): bool
    {
        foreach ($this->guards as $guard) {

            if (!$guard->isAllowed($request, $state)) {
                $state->getStateMachine()->executionLog[] = 'Guard ' . get_class($guard) . ' prevents transition to ' . get_class($this->endState);
                return false;
            }
            $state->getStateMachine()->executionLog[] = 'Guard ' . get_class($guard) . ' allows transition to ' . get_class($this->endState);
        }

        return true;
    }

    public function getEndState(): State
    {
        return $this->endState;
    }

}