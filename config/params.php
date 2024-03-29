<?php

declare(strict_types=1);

/**
 * Template module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-template
 * @package   Mailery\Template
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Definitions\DynamicReference;
use Twig\Extension\SandboxExtension;
use Twig\Sandbox\SecurityPolicy;

return [
    'yiisoft/yii-cycle' => [
        'entity-paths' => [
            '@vendor/maileryio/mailery-template/src/Entity',
        ],
    ],

    'maileryio/mailery-template' => [
        'types' => [],
        'twig' => [
            'extensions' => [
                DynamicReference::to(static fn () => new SandboxExtension(new SecurityPolicy()))
            ],
        ],
        'rendererCacheDirectory' => '@runtime/cache/twig',
    ],

    'maileryio/mailery-menu-sidebar' => [
        'items' => [
            'templates' => [
                'label' => static function () {
                    return 'Templates';
                },
                'icon' => 'email-multiple-outline',
                'items' => [
                    'templates' => [
                        'label' => 'All Templates',
                        'url' => static function (UrlGeneratorInterface $urlGenerator) {
                            return $urlGenerator->generate('/template/default/index');
                        },
                        'activeRouteNames' => [
                            '/template/default/index',
                        ],
                    ],
                ],
                'activeRouteNames' => [
                    '/template/default/index',
                ],
            ],
        ],
    ],
];
