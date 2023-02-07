<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Yiisoft\Form\ThemeDispatcher;

/**
 * @var array $params
 */

return [
    static function (ContainerInterface $container) use ($params) {
        ThemeDispatcher::initialize(
            $params['yiisoft/form']['configs'],
            $params['yiisoft/form']['defaultConfig'],
        );
    },
];
