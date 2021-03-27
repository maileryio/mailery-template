<?php

namespace Mailery\Template\Provider;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Router\RouteCollectorInterface;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Mailery\Template\Controller\DefaultController;

final class RouteCollectorServiceProvider extends ServiceProvider
{
    public function register(ContainerInterface $container): void
    {
        /** @var RouteCollectorInterface $collector */
        $collector = $container->get(RouteCollectorInterface::class);

        $collector->addGroup(
            Group::create(
                '/brand/{brandId:\d+}',
                [
                    Route::get('/templates', [DefaultController::class, 'index'])
                        ->name('/template/default/index'),
                    Route::delete('/template/default/delete/{id:\d+}', [DefaultController::class, 'delete'])
                        ->name('/template/default/delete'),
                ]
            )
        );
    }
}
