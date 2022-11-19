<?php

declare(strict_types=1);

/**
 * Template module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-template
 * @package   Mailery\Template
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Mailery\Template\Entity\Template;
use Mailery\Template\Repository\TemplateRepository;
use Cycle\ORM\ORMInterface;
use Psr\Container\ContainerInterface;
use Mailery\Template\Model\TemplateTypeList;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Yiisoft\Aliases\Aliases;

/** @var array $params */

return [
    Environment::class => static function (Aliases $aliases) use($params) {
        $twig = new Environment(
            new ArrayLoader(),
            [
                'cache' => $aliases->get($params['maileryio/mailery-template']['rendererCacheDirectory']),
                'charset' => 'utf-8',
            ]
        );
        return $twig;
    },

    TemplateTypeList::class => [
        '__construct()' => [
            'elements' => $params['maileryio/mailery-template']['types'],
        ],
    ],

    TemplateRepository::class => static function (ContainerInterface $container) {
        return $container
            ->get(ORMInterface::class)
            ->getRepository(Template::class);
    },
];
