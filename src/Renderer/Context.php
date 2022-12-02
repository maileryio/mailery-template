<?php

namespace Mailery\Template\Renderer;

use Mailery\Template\Renderer\ContextInterface;
use Mailery\Template\Renderer\ContextObserverInterface;

class Context implements ContextInterface
{

    /**
     * @var ContextObserverInterface|null
     */
    private ?ContextObserverInterface $observer;

    /**
     * @param array $params
     */
    public function __construct(
        private array $params = []
    ) {}

    /**
     * @inheritdoc
     */
    public function withObserver(ContextObserverInterface $observer): self
    {
        $new = clone $this;
        $new->observer = $observer;

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function add(string $key, mixed $param): self
    {
        if ($this->has($key)) {
            throw new \RuntimeException(sprintf('A context already have key "%s".', $key));
        }

        $this->params[$key] = $param;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function has(string $key): bool
    {
        return isset($this->params[$key]);
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        if ($this->observer !== null) {
            return array_map(
                function ($param) {
                    return $this->observer->observe($param);
                },
                $this->params
            );
        }

        return $this->params;
    }

}
