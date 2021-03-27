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
            Group::create('/brand/{brandId:\d+}')
                ->routes(
                    Route::get('/templates')
                        ->name('/template/default/index')
                        ->action([DefaultController::class, 'index']),
                    Route::delete('/template/default/delete/{id:\d+}')
                        ->name('/template/default/delete')
                        ->action([DefaultController::class, 'delete'])
            )
        );
    }
}
