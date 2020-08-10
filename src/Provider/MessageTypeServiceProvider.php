<?php

namespace Mailery\Template\Provider;

use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Di\Container;
use Yiisoft\Factory\Factory;
use Mailery\Template\Provider\TemplateTypeConfigs;

class TemplateTypeServiceProvider extends ServiceProvider
{
    /**
     * @param Container $container
     * @return void
     */
    public function register(Container $container): void
    {
        $factory = new Factory();
        $configs = $container->get(TemplateTypeConfigs::class)->getConfigs();
        foreach ($configs as $alias => $config) {
            $container->set($alias, fn () => $factory->create($config));
        }
    }
}
