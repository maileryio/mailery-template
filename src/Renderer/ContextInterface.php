<?php

namespace Mailery\Template\Renderer;

use Mailery\Template\Renderer\ContextObserverInterface;

interface ContextInterface
{

    /**
     * @param ContextObserverInterface $observer
     * @return self
     */
    public function withObserver(ContextObserverInterface $observer): self;

    /**
     * @param string $key
     * @param mixed $param
     * @return self
     */
    public function add(string $key, mixed $param): self;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @return array
     */
    public function toArray(): array;

}
