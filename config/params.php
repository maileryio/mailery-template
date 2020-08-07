<?php

declare(strict_types=1);

/**
 * Message module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-message
 * @package   Mailery\Message
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Mailery\Menu\MenuItem;
use Mailery\Message\Controller\MessageController;
use Opis\Closure\SerializableClosure;
use Yiisoft\Router\Route;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    'yiisoft/yii-cycle' => [
        'annotated-entity-paths' => [
            '@vendor/maileryio/mailery-message/src/Entity',
        ],
    ],

    'router' => [
        'routes' => [
            // Messages:
            '/message/message/index' => Route::get('/brand/{brandId:\d+}/messages', [MessageController::class, 'index'])
                ->name('/message/message/index'),
            '/message/message/view' => Route::get('/brand/{brandId:\d+}/message/message/view/{id:\d+}', [MessageController::class, 'view'])
                ->name('/message/message/view'),
            '/message/message/create' => Route::methods(['GET', 'POST'], '/brand/{brandId:\d+}/message/message/create', [MessageController::class, 'create'])
                ->name('/message/message/create'),
            '/message/message/edit' => Route::methods(['GET', 'POST'], '/brand/{brandId:\d+}/message/message/edit/{id:\d+}', [MessageController::class, 'edit'])
                ->name('/message/message/edit'),
            '/message/message/delete' => Route::delete('/brand/{brandId:\d+}/message/message/delete/{id:\d+}', [MessageController::class, 'delete'])
                ->name('/message/message/delete'),
        ],
    ],

    'menu' => [
        'sidebar' => [
            'items' => [
                'messages' => (new MenuItem())
                    ->withLabel('Messages')
                    ->withIcon('email-multiple-outline')
                    ->withChildItems([
                        'messages' => (new MenuItem())
                            ->withLabel('All Messages')
                            ->withUrl(new SerializableClosure(function (UrlGeneratorInterface $urlGenerator) {
                                return $urlGenerator->generate('/message/message/index');
                            }))
                            ->withActiveRouteNames([
                                '/message/message/index',
                                '/message/message/view',
                                '/message/message/create',
                                '/message/message/edit',
                                '/message/message/delete',
                            ])
                            ->withOrder(100),
                    ])
                    ->withOrder(400),
            ],
        ],
    ],
];
