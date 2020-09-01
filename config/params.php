<?php

declare(strict_types=1);

/**
 * Template module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-template
 * @package   Mailery\Template
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Mailery\Menu\MenuItem;
use Mailery\Template\Controller\DefaultController;
use Opis\Closure\SerializableClosure;
use Yiisoft\Router\Route;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    'maileryio/mailery-template' => [
        'types' => [],
    ],

    'yiisoft/yii-cycle' => [
        'annotated-entity-paths' => [
            '@vendor/maileryio/mailery-template/src/Entity',
        ],
    ],

    'router' => [
        'routes' => [
            '/template/default/index' => Route::get('/brand/{brandId:\d+}/templates', [DefaultController::class, 'index'])
                ->name('/template/default/index'),
//            '/template/default/view' => Route::get('/brand/{brandId:\d+}/template/view/{id:\d+}', [DefaultController::class, 'view'])
//                ->name('/template/default/view'),
//            '/template/default/create' => Route::methods(['GET', 'POST'], '/brand/{brandId:\d+}/template/create', [DefaultController::class, 'create'])
//                ->name('/template/default/create'),
//            '/template/default/edit' => Route::methods(['GET', 'POST'], '/brand/{brandId:\d+}/template/edit/{id:\d+}', [DefaultController::class, 'edit'])
//                ->name('/template/default/edit'),
//            '/template/default/delete' => Route::delete('/brand/{brandId:\d+}/template/delete/{id:\d+}', [DefaultController::class, 'delete'])
//                ->name('/template/default/delete'),
        ],
    ],

    'menu' => [
        'sidebar' => [
            'items' => [
                'templates' => (new MenuItem())
                    ->withLabel('Templates')
                    ->withIcon('email-multiple-outline')
                    ->withChildItems([
                        'templates' => (new MenuItem())
                            ->withLabel('All Templates')
                            ->withUrl(new SerializableClosure(function (UrlGeneratorInterface $urlGenerator) {
                                return $urlGenerator->generate('/template/default/index');
                            }))
                            ->withActiveRouteNames([
                                '/template/default/index',
//                                '/template/default/view',
//                                '/template/default/create',
//                                '/template/default/edit',
//                                '/template/default/delete',
                            ])
                            ->withOrder(100),
                    ])
                    ->withOrder(400),
            ],
        ],
    ],
];
