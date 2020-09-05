<?php

namespace Mailery\Template\Provider;

use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Router\RouteCollectorInterface;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Mailery\Template\Controller\DefaultController;

final class RouteCollectorServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        /** @var RouteCollectorInterface $collector */
        $collector = $container->get(RouteCollectorInterface::class);

        $collector->addGroup(
            Group::create(
                '/brand/{brandId:\d+}',
                [
                    Route::get('/templates', [DefaultController::class, 'index'])
                        ->name('/template/default/index'),
//                    '/template/default/view' => Route::get('/brand/{brandId:\d+}/template/view/{id:\d+}', [DefaultController::class, 'view'])
//                        ->name('/template/default/view'),
//                    '/template/default/create' => Route::methods(['GET', 'POST'], '/brand/{brandId:\d+}/template/create', [DefaultController::class, 'create'])
//                        ->name('/template/default/create'),
//                    '/template/default/edit' => Route::methods(['GET', 'POST'], '/brand/{brandId:\d+}/template/edit/{id:\d+}', [DefaultController::class, 'edit'])
//                        ->name('/template/default/edit'),
//                    '/template/default/delete' => Route::delete('/brand/{brandId:\d+}/template/delete/{id:\d+}', [DefaultController::class, 'delete'])
//                        ->name('/template/default/delete'),
                ]
            )
        );
    }
}
