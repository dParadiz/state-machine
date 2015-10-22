<?php
namespace StateMachine;


trait Variables
{
    /**
     * @var \ArrayObject
     */
    private $variables;

    /**
     * @param $name
     * @param $value
     */
    public function setVariable($name, $value)
    {
        if (null === $this->variables) {
            $this->variables = new \ArrayObject();
        }

        $this->variables->offsetSet($name, $value);
    }

    /**
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public function getVariable($name, $default = null)
    {
        if (null !== $this->variables && $this->variables->offsetExists($name)) {
            return $this->variables->offsetGet($name);
        }

        return $default;
    }

    /**
     * @param $variable
     */
    public function removeVariable($variable)
    {
        if (null === $this->variables) {
            return;
        }
        if ($this->variables->offsetExists($variable)) {
            $this->variables->offsetUnset($variable);
        }
    }
}