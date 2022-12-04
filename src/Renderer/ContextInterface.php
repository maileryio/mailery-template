<?php

namespace Mailery\Template\Renderer;

interface ContextInterface
{

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed;

    /**
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function add(string $key, mixed $value): self;

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
