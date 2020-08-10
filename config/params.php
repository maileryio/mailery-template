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
use Mailery\Template\Controller\TemplateController;
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
            // Templates:
            '/template/template/index' => Route::get('/brand/{brandId:\d+}/templates', [TemplateController::class, 'index'])
                ->name('/template/template/index'),
            '/template/template/view' => Route::get('/brand/{brandId:\d+}/template/template/view/{id:\d+}', [TemplateController::class, 'view'])
                ->name('/template/template/view'),
            '/template/template/create' => Route::methods(['GET', 'POST'], '/brand/{brandId:\d+}/template/template/create', [TemplateController::class, 'create'])
                ->name('/template/template/create'),
            '/template/template/edit' => Route::methods(['GET', 'POST'], '/brand/{brandId:\d+}/template/template/edit/{id:\d+}', [TemplateController::class, 'edit'])
                ->name('/template/template/edit'),
            '/template/template/delete' => Route::delete('/brand/{brandId:\d+}/template/template/delete/{id:\d+}', [TemplateController::class, 'delete'])
                ->name('/template/template/delete'),
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
                                return $urlGenerator->generate('/template/template/index');
                            }))
                            ->withActiveRouteNames([
                                '/template/template/index',
                                '/template/template/view',
                                '/template/template/create',
                                '/template/template/edit',
                                '/template/template/delete',
                            ])
                            ->withOrder(100),
                    ])
                    ->withOrder(400),
            ],
        ],
    ],
];
