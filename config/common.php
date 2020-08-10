<?php

declare(strict_types=1);

/**
 * Template module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-template
 * @package   Mailery\Template
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Mailery\Template\Provider\TemplateTypeConfigs;

return [
    TemplateTypeConfigs::class => static function () use ($params) {
        $configs = $params['maileryio/mailery-template']['types'] ?? [];
        return new TemplateTypeConfigs($configs);
    }
];
