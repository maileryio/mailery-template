<?php

namespace Mailery\Template\Renderer;

interface ContextObserverInterface
{

    /**
     * @param mixed $param
     * @return self
     */
    public function observe(mixed $param): self;

    /**
     * @return array
     */
    public function getContext(): array;

}
