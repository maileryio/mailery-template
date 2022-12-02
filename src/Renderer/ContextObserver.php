<?php

namespace Mailery\Template\Renderer;

use Mailery\Template\Renderer\ContextObserverInterface;

class ContextObserver implements ContextObserverInterface
{

    /**
     * @var mixed
     */
    private mixed $param;

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this->param, $name)) {
            return call_user_func_array([$this->param, $name], $arguments);
        }

        return null;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->param->$name;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->param->$name);
    }

    /**
     * @inheritdoc
     */
    public function observe(mixed $param): self
    {
        $new = clone $this;
        $new->param = $param;

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function getContext(): array
    {
        return [];
    }

}
