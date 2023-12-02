<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Yiisoft\Form\ThemeContainer;

/**
 * @var array $params
 */

return [
    static function (ContainerInterface $container) use ($params) {
        ThemeContainer::initialize(
            $params['yiisoft/form']['themes'],
            $params['yiisoft/form']['defaultTheme'],
            $params['yiisoft/form']['validationRulesEnricher'],
        );
    },
];
