<?php

namespace Mailery\Template\Provider;

use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Di\Container;
use Yiisoft\Factory\Factory;
use Mailery\Template\Provider\TemplateTypeConfigs;
use Mailery\Template\Model\TemplateTypeList;

final class TemplateTypeServiceProvider extends ServiceProvider
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

        $container->set(
            TemplateTypeList::class,
            function () use($container, $configs) {
                $types = array_map(
                    function ($type) use($container) {
                        return $container->get($type);
                    },
                    array_keys($configs)
                );

                return new TemplateTypeList($types);
            }
        );
    }
}
