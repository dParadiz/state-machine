<?php
namespace StateMachine;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionRepository implements Repository
{
    const STORAGE_KEY = 'stateMachine';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * SessionRepository constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @return StateMachine
     */
    public function fetch()
    {
        if ($this->session->has(self::STORAGE_KEY)) {
            return $this->session->get(self::STORAGE_KEY);
        }

    }

    /**
     * @param StateMachine $stateMachine
     */
    public function store(StateMachine $stateMachine)
    {
        $this->session->set(self::STORAGE_KEY, $stateMachine);
    }
}