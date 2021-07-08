<?php declare(strict_types=1);

namespace StateMachine;

trait Variables
{
    private \ArrayObject $variables;

    public function setVariable(string|int $name, mixed $value)
    {
        if (!isset($this->variables)) {
            $this->variables = new \ArrayObject();
        }

        $this->variables->offsetSet($name, $value);
    }

    public function getVariable(string|int $name, mixed $default = null): mixed
    {
        if (isset($this->variables) && $this->variables->offsetExists($name)) {
            return $this->variables->offsetGet($name);
        }

        return $default;
    }

    public function removeVariable(string|int $variable): void
    {
        if (!isset($this->variables)) {
            return;
        }
        if ($this->variables->offsetExists($variable)) {
            $this->variables->offsetUnset($variable);
        }
    }
}