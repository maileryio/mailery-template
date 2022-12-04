<?php

namespace Mailery\Template\Renderer;

use Mailery\Template\Renderer\ContextInterface;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Strings\StringHelper;
use Yiisoft\Strings\Inflector;

class Context implements ContextInterface
{

    /**
     * @param array $params
     */
    public function __construct(
        private array $params = []
    ) {}

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        $params = $this->toArray();
        $parsedPath = StringHelper::parsePath($key);

        $result = null;

        foreach($parsedPath as $key) {
            if (is_array($params)) {
                $params = $result = $params[$key] ?? null;
            } else if (is_object($params)) {
                $methodName = 'get' . (new Inflector())->toPascalCase($key);

                if (is_callable([$params, $methodName])) {
                    $params = $result = $params->$methodName();
                }
            }
        }

        return $result;
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
        return $this->get($key) !== null;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->params;
    }

}
