<?php

namespace Mailery\Template\Renderer;

use Mailery\Template\Renderer\ContextInterface;

class Context implements ContextInterface
{

    /**
     * @param array $params
     */
    public function __construct(
        private array $params
    ) {}

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->params;
    }

}
